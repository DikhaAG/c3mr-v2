<?php

namespace App\Filament\Resources\Keterangans\Pages;

use App\Filament\Resources\Keterangans\KeteranganResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKeterangan extends EditRecord
{
    protected static string $resource = KeteranganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
