<?php

namespace App\Filament\Resources\Pelanggans\Tables;

use App\Models\Pelanggan;
use App\Filament\Imports\PelangganImporter;
use Filament\Tables\Table;
use Filament\Tables as Tables;
use Filament\Forms as Forms;
use Filament\Actions as Actions;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class PelanggansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->filtersTriggerAction(
                fn(Action $action) => $action
                    ->icon('heroicon-m-funnel')
                    ->color('danger'),
            )
            ->headerActions([
                /* Actions\ImportAction::make()->importer(PelangganImporter::class), */
                Actions\ImportAction::make()->label('Import Data Call')
                    ->importer(PelangganImporter::class),
                /* ->disabled(function () { */
                /*     return Pelanggan::whereDate('created_at', today())->exists(); */
                /* }) */
                /* ->tooltip(function () { */
                /*     return Pelanggan::whereDate('created_at', today())->exists() */
                /*         ? 'Import dikunci karena data call hari ini sudah ada' */
                /*         : null; */
                /* }),        */
            ])
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')->date()->sortable()->searchable(),
                Tables\Columns\TextColumn::make('id_pelanggan')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('nama_pelanggan')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('cp')->searchable(),
                Tables\Columns\TextColumn::make('domisili')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('regional')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('branch')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('los')->sortable(),
                Tables\Columns\TextColumn::make('habit_category'),
                Tables\Columns\TextColumn::make('total_tagihan')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('admin')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('r_caring_status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'CONTACTED' => 'success',      // Hijau (Teks Putih)
                        'NOT CONTACTED' => 'danger',   // Merah (Teks Putih)
                        default => 'gray',
                    })
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('keterangan')->sortable(),
                Tables\Columns\TextColumn::make('keterangan2')->label('keterangan Tambahan'),
                Tables\Columns\TextColumn::make('paket')->hidden(),
                Tables\Columns\TextColumn::make('tgl_aktivasi')->date()->sortable(),
                Tables\Columns\TextColumn::make('status_bayar')->sortable(),
                Tables\Columns\TextColumn::make('payment_date')->date()->sortable(),
                Tables\Columns\TextColumn::make('payment_amount')->numeric(locale: 'id')->sortable(),
            ])
            ->filters([
                Filter::make('tanggal')
                    ->schema([
                        Forms\Components\DatePicker::make('dari_tanggal')->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('sampai_tanggal')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['dari_tanggal'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tanggal', '>=', $date),
                            )
                            ->when(
                                $data['sampai_tanggal'],
                                fn(Builder $query, $date): Builder => $query->whereDate('tanggal', '<=', $date),
                            );
                    }),
                // TAMBAHKAN FILTER RADIO BUTTON DI SINI
                Tables\Filters\SelectFilter::make('r_caring_status')
                    ->label('Status Caring')
                    ->options([
                        'CONTACTED' => 'Contacted',
                        'NOT CONTACTED' => 'Not Contacted',
                        'null' => 'Tidak ada', // Kita gunakan string 'null' sebagai kunci sementara
                    ])
                    ->native(false)
                    ->query(function (Builder $query, array $data) {
                        if ($data['value'] === 'null') {
                            return $query->whereNull('r_caring_status');
                        }

                        return $query->when(
                            $data['value'],
                            fn(Builder $query, $value) => $query->where('r_caring_status', $value)
                        );
                    }),
            ])
            ->recordActions([
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
