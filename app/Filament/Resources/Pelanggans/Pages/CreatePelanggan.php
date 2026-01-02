<?php

namespace App\Filament\Resources\Pelanggans\Pages;

use App\Filament\Resources\Pelanggans\PelangganResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePelanggan extends CreateRecord
{
    protected static string $resource = PelangganResource::class;
    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),   // tombol Create
            $this->getCancelFormAction(),   // tombol Cancel
        ];
    }
}
