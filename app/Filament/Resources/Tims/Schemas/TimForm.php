<?php

namespace App\Filament\Resources\Tims\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use App\Models\Regional;
use App\Models\Branch;

class TimForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Tim')
                    ->schema([
                        TextInput::make('username')
                            ->required()
                            ->unique(ignoreRecord: true),
                        TextInput::make('nama_lengkap')
                            ->required(),
                    ])->columns(2),

                Section::make('Lokasi')
                    ->schema([
                        Select::make('regional')
                            ->options(fn() => Regional::pluck('nama', 'nama'))
                            ->searchable()
                            ->required(),
                        Select::make('branch')
                            ->options(fn() => Branch::pluck('nama', 'nama'))
                            ->searchable()
                            ->required(),
                    ])->columns(2),
            ]);
    }
}
