<?php

namespace App\Filament\Resources\Fungsis\Tables;

use App\Filament\Imports\FungsiImporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ImportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FungsisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->headerActions([
                // Gunakan kelas yang sudah di-import di atas
                ImportAction::make()
                    ->importer(FungsiImporter::class)
                    ->label('Import Fungsi')
                    ->modalHeading('Unggah File (CSV/XLSX)')
                    ->modalDescription('Pastikan file berisi kolom/header bernama "fungsi"'),
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
