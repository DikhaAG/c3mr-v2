<?php

namespace App\Filament\Resources\Keterangans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KeteranganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
            ]);
    }
}
