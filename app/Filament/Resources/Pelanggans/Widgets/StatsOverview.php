<?php

namespace App\Filament\Resources\Pelanggans\Widgets;

use App\Models\Pelanggan;
use App\Models\Tim;
/* use App\Models\RCaringStatus; */
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Number; // Standar baru Laravel untuk format angka

class StatsOverview extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected int|string|array $columnSpan = 'full';
    // Atau atur grid-nya
    protected function getColumns(): int
    {
        return 3; // Menampilkan 3 card per baris (akan jadi 2 baris)
    }
    protected function getStats(): array
    {
        // Mengambil filter dari Page (Filament 4 menggunakan struktur array yang sama)
        $startDate = $this->filters['from'] ?? null;
        $endDate = $this->filters['until'] ?? null;
        $los = $this->filters['los_bucket'] ?? null;

        // Base query dengan filter tanggal
        $query = Pelanggan::query()
            ->when($startDate, fn($q) => $q->whereDate('tanggal', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('tanggal', '<=', $endDate))
            ->when($los, fn($q) => $this->applyLosFilter($q, $los));
        ;

        return [
            Stat::make('Total Pelanggan', $query->count())
                ->icon('heroicon-m-users'),

            Stat::make('Total Tagihan', Number::currency($query->sum('total_tagihan'), 'IDR', 'id'))
                ->icon('heroicon-m-banknotes'),

            Stat::make(
                'Total Call Tim',
                // Clone query agar filter tanggal tetap terbawa namun tidak merusak query utama
                (clone $query)->whereIn('admin', Tim::pluck('nama_lengkap'))->count()
            )->icon('heroicon-m-phone-arrow-up-right'),
            // Card Baru: Contacted
            Stat::make('Contacted', (clone $query)->where('r_caring_status', 'CONTACTED')->count())
                ->description('Pelanggan berhasil dihubungi')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->icon('heroicon-m-phone'),

            // Card Baru: Not Contacted
            Stat::make('Not Contacted', (clone $query)->where('r_caring_status', 'NOT CONTACTED')->count())
                ->description('Pelanggan gagal dihubungi')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger')
                ->icon('heroicon-m-phone-x-mark'),

            // Card Baru: Belum di-Call (NULL)
            Stat::make('Belum di-Call', (clone $query)->whereNull('r_caring_status')->count())
                ->description('Menunggu tindakan')
                ->descriptionIcon('heroicon-m-clock')
                ->color('gray')
                ->icon('heroicon-m-minus-circle'),
            /**/
            /* Stat::make( */
            /*     'Match Caring Status', */
            /*     (clone $query)->whereIn('r_caring_status', RCaringStatus::pluck('nama'))->count() */
            /* )->icon('heroicon-m-shield-check'), */
        ];
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
