<?php

namespace App\Filament\Resources\Tims\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TimForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('username')
                    ->required(),
                TextInput::make('nama_lengkap')
                    ->required(),
                TextInput::make('regional')
                    ->required(),
                TextInput::make('branch')
                    ->required(),
            ]);
    }
}
