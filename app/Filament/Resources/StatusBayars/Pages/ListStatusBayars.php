<?php

namespace App\Filament\Resources\StatusBayars\Pages;

use App\Filament\Resources\StatusBayars\StatusBayarResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStatusBayars extends ListRecords
{
    protected static string $resource = StatusBayarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
