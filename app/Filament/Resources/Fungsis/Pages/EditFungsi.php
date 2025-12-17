<?php

namespace App\Filament\Resources\Fungsis\Pages;

use App\Filament\Resources\Fungsis\FungsiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFungsi extends EditRecord
{
    protected static string $resource = FungsiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
