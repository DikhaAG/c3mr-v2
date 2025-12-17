<?php

namespace App\Filament\Resources\Fungsis\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FungsiForm
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
