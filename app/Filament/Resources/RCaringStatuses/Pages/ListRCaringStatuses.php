<?php

namespace App\Filament\Resources\RCaringStatuses\Pages;

use App\Filament\Resources\RCaringStatuses\RCaringStatusResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRCaringStatuses extends ListRecords
{
    protected static string $resource = RCaringStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
