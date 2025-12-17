<?php

namespace App\Filament\Resources\RCaringStatuses\Pages;

use App\Filament\Resources\RCaringStatuses\RCaringStatusResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRCaringStatus extends EditRecord
{
    protected static string $resource = RCaringStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
