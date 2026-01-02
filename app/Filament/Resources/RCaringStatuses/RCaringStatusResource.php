<?php

namespace App\Filament\Resources\RCaringStatuses;

use App\Filament\Resources\RCaringStatuses\Pages\CreateRCaringStatus;
use App\Filament\Resources\RCaringStatuses\Pages\EditRCaringStatus;
use App\Filament\Resources\RCaringStatuses\Pages\ListRCaringStatuses;
use App\Filament\Resources\RCaringStatuses\Schemas\RCaringStatusForm;
use App\Filament\Resources\RCaringStatuses\Tables\RCaringStatusesTable;
use App\Models\RCaringStatus;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class RCaringStatusResource extends Resource
{
    protected static ?string $navigationLabel = 'Status Call';
    protected static ?string $model = RCaringStatus::class;

    protected static string|UnitEnum|null $navigationGroup = 'Data';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::PhoneArrowUpRight;

    protected static bool $shouldRegisterNavigation = false;
    public static function form(Schema $schema): Schema
    {
        return RCaringStatusForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RCaringStatusesTable::configure($table);
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
            'index' => ListRCaringStatuses::route('/'),
            'create' => CreateRCaringStatus::route('/create'),
            'edit' => EditRCaringStatus::route('/{record}/edit'),
        ];
    }
}
