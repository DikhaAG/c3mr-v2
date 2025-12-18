<?php

namespace App\Filament\Resources\Pelanggans\Tables;

use App\Models\Pelanggan;
use App\Models\Tim;
use App\Models\RCaringStatus;
use App\Models\Keterangan;
use App\Models\Paket;
use App\Models\StatusBayar;
use App\Filament\Imports\PelangganImporter;
use Filament\Tables\Table;
// Import Alias untuk Filament 4
use Filament\Tables as Tables;
use Filament\Forms as Forms;
use Filament\Actions as Actions;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class PelanggansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->headerActions([
                // Di v4, ImportAction di-import dari Filament\Actions
                Actions\ImportAction::make()->importer(PelangganImporter::class),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')->date()->sortable()->searchable(),
                Tables\Columns\TextColumn::make('id_pelanggan')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('nama_pelanggan')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('cp')->searchable(),
                Tables\Columns\TextColumn::make('domisili')->searchable(),
                Tables\Columns\TextColumn::make('regional')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('branch')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('los'),
                Tables\Columns\TextColumn::make('habit_category'),
                Tables\Columns\TextColumn::make('total_tagihan')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('admin')->searchable(),
                Tables\Columns\TextColumn::make('r_caring_status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'CONTACTED' => 'success',      // Hijau (Teks Putih)
                        'NOT CONTACTED' => 'danger',   // Merah (Teks Putih)
                        default => 'gray',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('keterangan'),
                Tables\Columns\TextColumn::make('paket'),
                Tables\Columns\TextColumn::make('tgl_aktivasi')->date(),
                Tables\Columns\TextColumn::make('status_bayar'),
                Tables\Columns\TextColumn::make('payment_date')->date(),
                Tables\Columns\TextColumn::make('payment_amount')->numeric(locale: 'id'),
            ])
            ->recordActions([ // Sesuai standar v4 menggantikan actions()
                // ACTION CALL
                Actions\Action::make('call')
                    ->icon('heroicon-m-phone')
                    ->color('info')
                    ->schema([ // Menggantikan form() di v4
                        Forms\Components\Select::make('admin')
                            ->options(fn() => Tim::pluck('nama_lengkap', 'nama_lengkap'))
                            ->searchable(),
                        Forms\Components\Select::make('r_caring_status')
                            ->options(fn() => RCaringStatus::pluck('nama', 'nama'))
                            ->searchable(),
                        Forms\Components\Select::make('keterangan')
                            ->options(fn() => Keterangan::pluck('nama', 'nama'))
                            ->searchable(),
                    ])
                    ->action(fn(Pelanggan $record, array $data) => $record->update($data)),

                // ACTION BAYAR
                Actions\Action::make('bayar')
                    ->icon('heroicon-m-banknotes')
                    ->color('success')
                    ->schema([ // Menggantikan form() di v4
                        Forms\Components\Select::make('paket')
                            ->options(fn() => Paket::pluck('nama', 'nama'))
                            ->searchable(),
                        Forms\Components\DatePicker::make('tgl_aktivasi'),
                        Forms\Components\Select::make('status_bayar')
                            ->options(fn() => StatusBayar::pluck('nama', 'nama'))
                            ->searchable(),
                        Forms\Components\DatePicker::make('payment_date'),
                        Forms\Components\TextInput::make('payment_amount')->numeric(),
                    ])
                    ->action(fn(Pelanggan $record, array $data) => $record->update($data)),

                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);

    }
}
