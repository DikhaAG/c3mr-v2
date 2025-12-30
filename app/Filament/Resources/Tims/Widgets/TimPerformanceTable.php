<?php

namespace App\Filament\Resources\Tims\Widgets;

use App\Models\Tim;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters; // Tambahkan ini untuk filter tanggal
use Illuminate\Database\Eloquent\Builder;

class TimPerformanceTable extends TableWidget
{
    use InteractsWithPageFilters;

    // Membuat widget melebar memenuhi dashboard
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        // Mengambil filter tanggal dari Dashboard
        $startDate = $this->filters['from'] ?? null;
        $endDate = $this->filters['until'] ?? null;
        $los = $this->filters['los_bucket'] ?? null;

        return $table
            ->query(
                Tim::query()
                    ->withCount([
                        // Total pelanggan dimana pelanggan.admin == tim.nama_lengkap
                        'pelanggans as total_pelanggan' => function (Builder $query) use ($startDate, $endDate, $los) {
                            $query->when($startDate, fn($q) => $q->whereDate('tanggal', '>=', $startDate))
                                ->when($endDate, fn($q) => $q->whereDate('tanggal', '<=', $endDate))
                                ->when($los, fn($q) => $this->applyLosFilter($q, $los));
                        },
                        // Hitung status CONTACTED
                        'pelanggans as count_contacted' => function (Builder $query) use ($startDate, $endDate, $los) {
                            $query->where('r_caring_status', 'CONTACTED')
                                ->when($startDate, fn($q) => $q->whereDate('tanggal', '>=', $startDate))
                                ->when($endDate, fn($q) => $q->whereDate('tanggal', '<=', $endDate))
                                ->when($los, fn($q) => $this->applyLosFilter($q, $los));
                        },
                        // Hitung status NOT CONTACTED
                        'pelanggans as count_not_contacted' => function (Builder $query) use ($startDate, $endDate, $los) {
                            $query->where('r_caring_status', 'NOT CONTACTED')
                                ->when($startDate, fn($q) => $q->whereDate('tanggal', '>=', $startDate))
                                ->when($endDate, fn($q) => $q->whereDate('tanggal', '<=', $endDate))
                                ->when($los, fn($q) => $this->applyLosFilter($q, $los));
                        },
                    ])
            )
            ->columns([
                TextColumn::make('nama_lengkap')
                    ->label('Nama Tim')
                    ->searchable(),

                TextColumn::make('total_pelanggan')
                    ->label('Total Pelanggan')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                // Status CONTACTED: Hijau + Icon phone-arrow-down-left
                TextColumn::make('count_contacted')
                    ->label('Contacted')
                    ->icon('heroicon-m-phone-arrow-down-left')
                    ->iconColor('success')
                    ->color('success')
                    ->sortable()
                    ->formatStateUsing(fn($state) => "{$state} Data"),

                // Status NOT CONTACTED: Merah + Icon phone-x-mark
                TextColumn::make('count_not_contacted')
                    ->label('Not Contacted')
                    ->icon('heroicon-m-phone-x-mark')
                    ->iconColor('danger')
                    ->color('danger')
                    ->sortable()
                    ->formatStateUsing(fn($state) => "{$state} Data"),
                TextColumn::make('regional')
                    ->label('Regional')
                    ->searchable(),
                TextColumn::make('branch')
                    ->label('Branch')
                    ->searchable(),

            ])
            // Default sorting berdasarkan total pelanggan terbanyak
            ->defaultSort('total_pelanggan', 'desc');
    }
    protected function applyLosFilter($query, string $bucket)
    {
        return match ($bucket) {
            '0-3'   => $query->whereBetween('los', [0, 3]),
            '4-6'   => $query->whereBetween('los', [4, 6]),
            '7-12'  => $query->whereBetween('los', [7, 12]),
            '12-24' => $query->whereBetween('los', [12, 24]),
            '24+'   => $query->where('los', '>', 24),
            default => $query,
        };
    }
}
