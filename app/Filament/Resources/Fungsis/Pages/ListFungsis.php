<?php

namespace App\Filament\Resources\Fungsis\Pages;

use App\Filament\Resources\Fungsis\FungsiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFungsis extends ListRecords
{
    protected static string $resource = FungsiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
