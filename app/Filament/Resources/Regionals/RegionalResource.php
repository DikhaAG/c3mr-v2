<?php

namespace App\Filament\Resources\Regionals;

use App\Filament\Resources\Regionals\Pages\CreateRegional;
use App\Filament\Resources\Regionals\Pages\EditRegional;
use App\Filament\Resources\Regionals\Pages\ListRegionals;
use App\Filament\Resources\Regionals\Schemas\RegionalForm;
use App\Filament\Resources\Regionals\Tables\RegionalsTable;
use App\Models\Regional;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class RegionalResource extends Resource
{
    protected static ?string $navigationLabel = 'Regional';
    protected static ?string $model = Regional::class;

    protected static string|UnitEnum|null $navigationGroup = 'Data';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::MapPin;

    public static function form(Schema $schema): Schema
    {
        return RegionalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RegionalsTable::configure($table);
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
            'index' => ListRegionals::route('/'),
            'create' => CreateRegional::route('/create'),
            'edit' => EditRegional::route('/{record}/edit'),
        ];
    }
}
