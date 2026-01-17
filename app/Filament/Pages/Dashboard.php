<?php

namespace App\Filament\Pages;

use App\Filament\Resources\Pelanggans\Widgets\StatsOverview;
use App\Filament\Resources\Tims\Widgets\TimPerformanceTable;
use App\Filament\Widgets\PelangganKeteranganChart;
use App\Filament\Widgets\PivotFilter;
use App\Filament\Widgets\RekapTimCards;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section; // Namespace baru untuk Layout di v4
use Filament\Schemas\Schema; // Menggantikan Form di v4
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use App\Exports\CaringExport;
use App\Models\Pelanggan;
use Filament\Actions\Action;
use Filament\Schemas\Components\View;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Los;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    /**
     * Di Filament 4, method filtersForm menggunakan type-hint Schema.
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportExcel')
                ->label('Export Excel')
                ->icon('heroicon-m-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    // 1. Ambil state filter yang sedang aktif di UI
                    $from = $this->filters['from'] ?? null;
                    $until = $this->filters['until'] ?? null;
                    $los = $this->filters['los_bucket'] ?? null;

                    // 2. Jalankan query data dengan filter yang sama
                    $data = Pelanggan::query()
                        ->selectRaw('DATE(created_at) as tanggal, admin, keterangan, COUNT(*) as total')
                        ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
                        ->when($until, fn($q) => $q->whereDate('created_at', '<=', $until))
                        ->when($los, fn($q) => $this->applyLosFilter($q, $los))
                        // Gunakan ekspresi DATE(created_at) di GROUP BY, bukan alias 'tanggal'
                        ->groupByRaw('DATE(created_at), admin, keterangan')
                        ->orderByRaw('DATE(created_at) asc')
                        ->get();

                    // 3. Download file Excel
                    return Excel::download(
                        new CaringExport($data),
                        'Data_Caring_' . now()->format('Ymd_His') . '.xlsx'
                    );
                }),
        ];
    }
    public function filtersForm(Schema $schema): Schema
    {
        return $schema->components([
            View::make('filament.schemas.components.filter-pivot')
                ->schema([
                    DatePicker::make('from')
                        ->label('Dari Tanggal')
                        ->native(false),

                    DatePicker::make('until')
                        ->label('Sampai Tanggal')
                        ->native(false),

                    Select::make('los_bucket')
                        ->label('LOS')
                        ->options(fn() => Los::query()->orderBy('nama')->pluck('nama', 'nama')->toArray())
                        ->placeholder('Semua LOS')
                        ->searchable()
                        ->native(false),
                ])

                ->viewData([
                    'title' => 'Filter Pivot',
                ]),
        ]);
    }
    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            TimPerformanceTable::class,
            /* PivotFilter::class, */
            PelangganKeteranganChart::class,
            RekapTimCards::class,
        ];
    }

    protected function applyLosFilter(Builder $query, string $losNama): Builder
    {
        return $query->where('los', $losNama);
    }

}
