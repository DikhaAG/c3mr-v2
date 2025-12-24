<?php

namespace App\Filament\Resources\StatusBayars;

use App\Filament\Resources\StatusBayars\Pages\CreateStatusBayar;
use App\Filament\Resources\StatusBayars\Pages\EditStatusBayar;
use App\Filament\Resources\StatusBayars\Pages\ListStatusBayars;
use App\Filament\Resources\StatusBayars\Schemas\StatusBayarForm;
use App\Filament\Resources\StatusBayars\Tables\StatusBayarsTable;
use App\Models\StatusBayar;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class StatusBayarResource extends Resource
{
    protected static ?string $navigationLabel = 'Status Bayar';
    protected static ?string $model = StatusBayar::class;

    protected static string|UnitEnum|null $navigationGroup = 'Data';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::CurrencyDollar;
    protected static bool $shouldRegisterNavigation = false;
    public static function form(Schema $schema): Schema
    {
        return StatusBayarForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StatusBayarsTable::configure($table);
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
            'index' => ListStatusBayars::route('/'),
            'create' => CreateStatusBayar::route('/create'),
            'edit' => EditStatusBayar::route('/{record}/edit'),
        ];
    }
}
