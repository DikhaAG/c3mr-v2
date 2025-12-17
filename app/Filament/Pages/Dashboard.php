<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Forms\Components\DatePicker;
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
        ]);
    }
}
