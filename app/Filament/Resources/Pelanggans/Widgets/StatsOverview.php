<?php

namespace App\Filament\Resources\Pelanggans\Widgets;

use App\Models\Pelanggan;
use App\Models\Tim;
use App\Models\DataBayar; // <-- TAMBAH: untuk ambil paid/unpaid dari tabel data_bayars
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Number;

class StatsOverview extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected int|string|array $columnSpan = 'full';

    protected function getColumns(): int
    {
        return 3;
    }

    protected function getStats(): array
    {
        $startDate = $this->filters['from'] ?? null;
        $endDate   = $this->filters['until'] ?? null;
        $los       = $this->filters['los_bucket'] ?? null;

        // Base query pelanggan (ini jadi "sumber kebenaran" filter dashboard)
        $pelangganQuery = Pelanggan::query()
            ->when($startDate, fn($q) => $q->whereDate('created_at', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('created_at', '<=', $endDate))
            ->when($los, fn($q) => $this->applyLosFilter($q, $los));

        /**
         * Query DataBayar yang "mengikuti" filter pelanggan.
         * Kita pakai subquery biar tetap efisien (tidak pluck ribuan baris ke PHP).
         *
         * Asumsi mapping:
         *  - data_bayars.account_number == pelanggans.id_pelanggan
         * Kalau ternyata beda, ganti kolom account_number di bawah ini.
         */
        $dataBayarQuery = DataBayar::query()
            ->whereIn('account_number', (clone $pelangganQuery)->select('id_pelanggan'));

        // === STAT BARU ===
        $totalJanjiBayar = (clone $pelangganQuery)
            ->where('keterangan', 'JANJI BAYAR')
            ->count();

        // Total tagihan paid/unpaid (pakai bill_amount_1 sebagai "nilai tagihan")
        // Kalau kamu maunya pakai jumlah_bayar untuk PAID, tinggal ganti sum()-nya.
        $totalPaid   = (clone $dataBayarQuery)->where('status_tagihan', 'PAID')->sum('bill_amount_1');
        $totalUnpaid = (clone $dataBayarQuery)->where('status_tagihan', 'UNPAID')->sum('bill_amount_1');

        // Optional: jumlah baris paid/unpaid (biar ada konteks)
        $countPaid   = (clone $dataBayarQuery)->where('status_tagihan', 'PAID')->count();
        $countUnpaid = (clone $dataBayarQuery)->where('status_tagihan', 'UNPAID')->count();

        return [
            Stat::make('Total Pelanggan', (clone $pelangganQuery)->count())
                ->icon('heroicon-m-users'),

            Stat::make('Total Tagihan', Number::currency((clone $pelangganQuery)->sum('total_tagihan'), 'IDR', 'id'))
                ->icon('heroicon-m-banknotes'),

            Stat::make(
                'Total Call Tim',
                (clone $pelangganQuery)->whereIn('admin', Tim::pluck('nama_lengkap'))->count()
            )->icon('heroicon-m-phone-arrow-up-right'),

            Stat::make('Contacted', (clone $pelangganQuery)->where('r_caring_status', 'CONTACTED')->count())
                ->description('Pelanggan berhasil dihubungi')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success')
                ->icon('heroicon-m-phone'),

            Stat::make('Not Contacted', (clone $pelangganQuery)->where('r_caring_status', 'NOT CONTACTED')->count())
                ->description('Pelanggan gagal dihubungi')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger')
                ->icon('heroicon-m-phone-x-mark'),

            Stat::make('Belum di-Call', (clone $pelangganQuery)->whereNull('r_caring_status')->count())
                ->description('Menunggu tindakan')
                ->descriptionIcon('heroicon-m-clock')
                ->color('gray')
                ->icon('heroicon-m-minus-circle'),

            // === TAMBAHAN: JANJI BAYAR ===
            Stat::make('Janji Bayar', $totalJanjiBayar)
                ->description('keterangan = JANJI BAYAR')
                ->descriptionIcon('heroicon-m-hand-raised')
                ->color('warning')
                ->icon('heroicon-m-document-check'),

            // === TAMBAHAN: TAGIHAN PAID/UNPAID dari data_bayars ===
            Stat::make('Tagihan PAID', Number::currency($totalPaid, 'IDR', 'id'))
                ->description($countPaid . ' baris (status_tagihan=PAID)')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success')
                ->icon('heroicon-m-credit-card'),

            Stat::make('Tagihan UNPAID', Number::currency($totalUnpaid, 'IDR', 'id'))
                ->description($countUnpaid . ' baris (status_tagihan=UNPAID)')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger')
                ->icon('heroicon-m-credit-card'),
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
