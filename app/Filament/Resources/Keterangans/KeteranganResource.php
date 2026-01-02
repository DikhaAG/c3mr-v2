<?php

namespace App\Filament\Resources\Keterangans;

use App\Filament\Resources\Keterangans\Pages\CreateKeterangan;
use App\Filament\Resources\Keterangans\Pages\EditKeterangan;
use App\Filament\Resources\Keterangans\Pages\ListKeterangans;
use App\Filament\Resources\Keterangans\Schemas\KeteranganForm;
use App\Filament\Resources\Keterangans\Tables\KeterangansTable;
use App\Models\Keterangan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class KeteranganResource extends Resource
{
    protected static ?string $navigationLabel = 'Keterangan';
    protected static ?string $model = Keterangan::class;

    protected static string|UnitEnum|null $navigationGroup = 'Data';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::PencilSquare;

    protected static bool $shouldRegisterNavigation = false;
    public static function form(Schema $schema): Schema
    {
        return KeteranganForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KeterangansTable::configure($table);
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
            'index' => ListKeterangans::route('/'),
            'create' => CreateKeterangan::route('/create'),
            'edit' => EditKeterangan::route('/{record}/edit'),
        ];
    }
}
