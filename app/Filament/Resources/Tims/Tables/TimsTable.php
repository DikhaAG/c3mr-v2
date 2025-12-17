<?php

namespace App\Filament\Resources\Tims\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TimsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            // Mengoptimalkan query dengan withCount
            ->modifyQueryUsing(fn($query) => $query->withCount('pelanggans'))
            ->columns([
                TextColumn::make('username')
                    ->searchable(),
                TextColumn::make('nama_lengkap')
                    ->searchable(),
                // Menampilkan Jumlah Pelanggan
                TextColumn::make('pelanggans_count')
                    ->label('Total Pelanggan')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                TextColumn::make('regional')
                    ->searchable(),
                TextColumn::make('branch')
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
