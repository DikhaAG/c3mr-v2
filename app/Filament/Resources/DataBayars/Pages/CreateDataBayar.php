<?php

namespace App\Filament\Resources\DataBayars\Pages;

use App\Filament\Resources\DataBayars\DataBayarResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDataBayar extends CreateRecord
{
    protected static string $resource = DataBayarResource::class;
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),   // tombol Create
            $this->getCancelFormAction(),   // tombol Cancel
        ];
    }
}
