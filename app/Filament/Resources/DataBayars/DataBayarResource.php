<?php

namespace App\Filament\Resources\DataBayars;

use App\Filament\Resources\DataBayars\Pages\CreateDataBayar;
use App\Filament\Resources\DataBayars\Pages\EditDataBayar;
use App\Filament\Resources\DataBayars\Pages\ListDataBayars;
use App\Filament\Resources\DataBayars\Schemas\DataBayarForm;
use App\Filament\Resources\DataBayars\Tables\DataBayarsTable;
use App\Models\DataBayar;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DataBayarResource extends Resource
{
    protected static ?string $model = DataBayar::class;

    protected static ?string $navigationLabel = 'Data Bayar';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function form(Schema $schema): Schema
    {
        return DataBayarForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DataBayarsTable::configure($table);
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
            'index' => ListDataBayars::route('/'),
            'create' => CreateDataBayar::route('/create'),
            'edit' => EditDataBayar::route('/{record}/edit'),
        ];
    }
}
