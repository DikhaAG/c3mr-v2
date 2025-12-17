<?php

namespace App\Filament\Resources\RCaringStatuses\Tables;

use App\Filament\Imports\RCaringStatusImporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ImportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RCaringStatusesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->headerActions([
                // Gunakan kelas yang sudah di-import di atas
                ImportAction::make()
                    ->importer(RCaringStatusImporter::class)
                    ->label('Import Status Call')
                    ->modalHeading('Unggah File (CSV/XLSX)')
                    ->modalDescription('Pastikan file berisi kolom/header bernama "r_caring_status"'),
            ])
            ->columns([
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
