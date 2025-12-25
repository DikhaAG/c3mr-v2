<?php

namespace App\Filament\Resources\DataBayars\Pages;

use App\Filament\Resources\DataBayars\DataBayarResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDataBayars extends ListRecords
{
    protected static string $resource = DataBayarResource::class;
    protected static ?string $title = 'Data Bayar';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('New Data Bayar'),
        ];
    }
}
