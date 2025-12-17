<?php

namespace App\Filament\Resources\Fungsis;

use App\Filament\Resources\Fungsis\Pages\CreateFungsi;
use App\Filament\Resources\Fungsis\Pages\EditFungsi;
use App\Filament\Resources\Fungsis\Pages\ListFungsis;
use App\Filament\Resources\Fungsis\Schemas\FungsiForm;
use App\Filament\Resources\Fungsis\Tables\FungsisTable;
use App\Models\Fungsi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class FungsiResource extends Resource
{
    protected static ?string $navigationLabel = 'Fungsi';
    protected static ?string $model = Fungsi::class;

    protected static string|UnitEnum|null $navigationGroup = 'Data';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserCircle;

    public static function form(Schema $schema): Schema
    {
        return FungsiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FungsisTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFungsis::route('/'),
            'create' => CreateFungsi::route('/create'),
            'edit' => EditFungsi::route('/{record}/edit'),
        ];
    }
}
