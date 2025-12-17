<?php

namespace App\Filament\Resources\RCaringStatuses\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RCaringStatusForm
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
