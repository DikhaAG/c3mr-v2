<?php

namespace App\Filament\Widgets;

use App\Models\Keterangan;
use App\Models\Pelanggan;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class PelangganKeteranganChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Tren Keterangan Pelanggan';

    protected function getData(): array
    {
        // Ambil filter dari PivotPage
        $from = $this->filters['from'] ?? null;
        $until = $this->filters['until'] ?? null;
        $los = $this->filters['los_bucket'] ?? null;

        $rows = Pelanggan::query()
            ->selectRaw('DATE(created_at) as tanggal, keterangan, COUNT(*) as total')
            ->when(
                $from,
                fn(Builder $q)
                => $q->whereDate('created_at', '>=', $from)
            )
            ->when(
                $until,
                fn(Builder $q)
                => $q->whereDate('created_at', '<=', $until)
            )
            ->when(
                $los,
                fn(Builder $q)
                => $this->applyLosFilter($q, $los)
            )
            ->groupByRaw('DATE(created_at), keterangan')
            ->orderBy('tanggal')
            ->get();

        $labelsRaw = $rows
            ->pluck('tanggal')
            ->unique()
            ->values();

        $labels = $labelsRaw->map(
            fn($tgl) => Carbon::parse($tgl)->translatedFormat('d M y')
        );

        $colorMap = $this->buildColorMap();

        $datasets = $rows
            ->groupBy('keterangan')
->map(function ($items, $ket) use ($labelsRaw, $colorMap) {
    $color = $colorMap[$ket] ?? 'hsl(0, 0%, 70%)';

    return [
        'label' => $ket,
        'data' => $labelsRaw->map(
            fn($tgl)
                => $items->firstWhere('tanggal', $tgl)?->total ?? 0
        )->toArray(),
        'borderColor' => $color,
        'backgroundColor' => $color,
        'borderWidth' => 2,
        'tension' => 0.3,
    ];
})
            ->values()
            ->toArray();

        return [
            'labels' => $labels->toArray(),
            'datasets' => $datasets,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    /**
     * LOS bucket filter
     */

    protected function applyLosFilter(Builder $query, string $losNama): Builder
    {
        return $query->where('los', $losNama);
    }


    /**
     * Buat colormap otomatis dari tabel keterangan
     */
    protected function buildColorMap(): array
    {
        return Keterangan::query()
            ->pluck('nama')
            ->mapWithKeys(fn($nama) => [
                $nama => $this->stringToColor($nama),
            ])
            ->toArray();
    }

    protected function stringToColor(string $value): string
    {
        $hash = crc32($value);
        $hue = $hash % 360;

        return "hsl({$hue}, 65%, 55%)";
    }
}
