<?php

namespace App\Filament\Resources\Pelanggans\Pages;

use App\Filament\Resources\Pelanggans\PelangganResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPelanggans extends ListRecords
{
    protected static string $resource = PelangganResource::class;
    protected static ?string $title = 'Data Call';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
