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

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    /**
     * Di Filament 4, method filtersForm menggunakan type-hint Schema.
     */
    public function filtersForm(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()
                ->schema([
                    DatePicker::make('startDate')
                        ->label('Dari Tanggal')
                        ->native(false) // Opsional: agar UI lebih konsisten di v4
                        ->displayFormat('d/m/Y'),
                    DatePicker::make('endDate')
                        ->label('Sampai Tanggal')
                        ->native(false)
                        ->displayFormat('d/m/Y'),
                ])
                ->columns(2),
            Section::make('Filter Pivot')
                ->schema([
                    DatePicker::make('from')
                        ->label('Dari Tanggal')
                        ->native(false),

                    DatePicker::make('until')
                        ->label('Sampai Tanggal')
                        ->native(false),

                    Select::make('los_bucket')
                        ->label('LOS')
                        ->options([
                            '0-3'   => '0–3 Bulan',
                            '4-6'   => '4–6 Bulan',
                            '7-12'  => '7–12 Bulan',
                            '12-24' => '12–24 Bulan',
                            '24+'   => '>24 Bulan',
                        ])
                        ->placeholder('Semua LOS'),
                ])
                ->columns(3),
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

}
