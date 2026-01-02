<?php

namespace App\Filament\Resources\Tims\Pages;

use App\Filament\Resources\Tims\TimResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTim extends CreateRecord
{
    protected static string $resource = TimResource::class;
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),   // tombol Create
            $this->getCancelFormAction(),   // tombol Cancel
        ];
    }
}
