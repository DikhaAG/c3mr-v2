<?php

namespace App\Filament\Resources\StatusBayars\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StatusBayarForm
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
