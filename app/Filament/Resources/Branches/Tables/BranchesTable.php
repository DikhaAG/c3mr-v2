<?php

namespace App\Filament\Resources\Branches\Tables;

use App\Filament\Imports\BranchImporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\ImportAction;

class BranchesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->headerActions([
                // Gunakan kelas yang sudah di-import di atas
                ImportAction::make()
                    ->importer(BranchImporter::class)
                    ->label('Import Branch')
                    ->modalHeading('Unggah File Branch (CSV/XLSX)'),
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
