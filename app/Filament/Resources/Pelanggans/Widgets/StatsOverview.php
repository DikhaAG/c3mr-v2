<?php

namespace App\Filament\Resources\Pelanggans\Widgets;

use App\Models\Pelanggan;
use App\Models\Tim;
use App\Models\RCaringStatus;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Number; // Standar baru Laravel untuk format angka

class StatsOverview extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        // Mengambil filter dari Page (Filament 4 menggunakan struktur array yang sama)
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        // Base query dengan filter tanggal
        $query = Pelanggan::query()
            ->when($startDate, fn($q) => $q->whereDate('tanggal', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('tanggal', '<=', $endDate));

        return [
            Stat::make('Total Pelanggan', $query->count())
                ->icon('heroicon-m-users'),

            Stat::make('Total Tagihan', Number::currency($query->sum('total_tagihan'), 'IDR', 'id'))
                ->icon('heroicon-m-banknotes'),

            Stat::make(
                'Match Admin/Tim',
                // Clone query agar filter tanggal tetap terbawa namun tidak merusak query utama
                (clone $query)->whereIn('admin', Tim::pluck('nama_lengkap'))->count()
            )->icon('heroicon-m-check-badge'),

            Stat::make(
                'Match Caring Status',
                (clone $query)->whereIn('r_caring_status', RCaringStatus::pluck('nama'))->count()
            )->icon('heroicon-m-shield-check'),
        ];
    }
}
