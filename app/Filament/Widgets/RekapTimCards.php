<?php

namespace App\Filament\Widgets;

use App\Models\Pelanggan;
use Filament\Widgets\Widget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class RekapTimCards extends Widget
{
    use InteractsWithPageFilters;

    protected string $view = 'filament.pages.rekap-tim-cards';

    protected function getViewData(): array
    {
        return [
            'tims' => $this->getTimData(),
        ];
    }

    protected function getTimData(): Collection
    {
        $from = $this->filters['from'] ?? null;
        $until = $this->filters['until'] ?? null;
        $los = $this->filters['los_bucket'] ?? null;

        return Pelanggan::query()
            ->selectRaw('admin, keterangan, COUNT(*) as total')
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
            ->groupBy('admin', 'keterangan')
            ->get()
            ->groupBy('admin')
            ->map(function ($rows, $admin) {
                return [
                    'nama' => $admin,
                    'items' => $rows->mapWithKeys(fn($r) => [
                        $r->keterangan => $r->total,
                    ]),
                    'total' => $rows->sum('total'),
                ];
            })
            ->values();
    }


    protected function applyLosFilter(Builder $query, string $losNama): Builder
    {
        return $query->where('los', $losNama);
    }

}
