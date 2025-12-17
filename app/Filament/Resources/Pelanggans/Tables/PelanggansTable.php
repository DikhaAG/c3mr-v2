<?php

namespace App\Filament\Resources\Pelanggans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PelanggansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal')
                    ->date()
                    ->sortable(),
                TextColumn::make('id_pelanggan')
                    ->searchable(),
                TextColumn::make('domisili')
                    ->searchable(),
                TextColumn::make('category_billing')
                    ->searchable(),
                TextColumn::make('nama_pelanggan')
                    ->searchable(),
                TextColumn::make('cp')
                    ->searchable(),
                TextColumn::make('branch')
                    ->searchable(),
                TextColumn::make('sto')
                    ->searchable(),
                TextColumn::make('los')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('habit_category')
                    ->searchable(),
                TextColumn::make('total_tagihan')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('fungsi')
                    ->searchable(),
                TextColumn::make('admin')
                    ->searchable(),
                TextColumn::make('r_caring_status')
                    ->searchable(),
                TextColumn::make('keterangan')
                    ->searchable(),
                TextColumn::make('paket')
                    ->searchable(),
                TextColumn::make('tgl_aktivasi')
                    ->date()
                    ->sortable(),
                TextColumn::make('status_bayar')
                    ->searchable(),
                TextColumn::make('payment_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('payment_amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('channel_bayar')
                    ->searchable(),
                TextColumn::make('regional')
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
