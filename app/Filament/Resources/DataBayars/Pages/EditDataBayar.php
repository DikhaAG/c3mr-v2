<?php

namespace App\Filament\Resources\DataBayars\Pages;

use App\Filament\Resources\DataBayars\DataBayarResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDataBayar extends EditRecord
{
    protected static string $resource = DataBayarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
