<?php

namespace App\Filament\Resources\Regionals\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RegionalForm
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
