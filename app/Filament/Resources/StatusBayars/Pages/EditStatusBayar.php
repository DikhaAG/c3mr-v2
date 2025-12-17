<?php

namespace App\Filament\Resources\StatusBayars\Pages;

use App\Filament\Resources\StatusBayars\StatusBayarResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStatusBayar extends EditRecord
{
    protected static string $resource = StatusBayarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
