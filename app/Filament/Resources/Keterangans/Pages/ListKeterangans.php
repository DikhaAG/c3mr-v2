<?php

namespace App\Filament\Resources\Keterangans\Pages;

use App\Filament\Resources\Keterangans\KeteranganResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKeterangans extends ListRecords
{
    protected static string $resource = KeteranganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
