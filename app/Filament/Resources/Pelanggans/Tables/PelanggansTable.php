<?php

namespace App\Filament\Resources\Pelanggans\Tables;

use App\Filament\Imports\PelangganImporter;
use App\Models\Keterangan; // ✅ tambah ini
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
                Actions\ImportAction::make()->label('Import Data Call')
                    ->importer(PelangganImporter::class),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->label('tanggal')->date()->sortable()->searchable(),
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
                        'CONTACTED' => 'success',
                        'NOT CONTACTED' => 'danger',
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
                                $data['dari_tanggal'] ?? null,
                                fn(Builder $query, $date): Builder => $query->whereDate('tanggal', '>=', $date),
                            )
                            ->when(
                                $data['sampai_tanggal'] ?? null,
                                fn(Builder $query, $date): Builder => $query->whereDate('tanggal', '<=', $date),
                            );
                    }),

                Tables\Filters\SelectFilter::make('r_caring_status')
                    ->label('Status Caring')
                    ->options([
                        'CONTACTED' => 'Contacted',
                        'NOT CONTACTED' => 'Not Contacted',
                        'null' => 'Tidak ada',
                    ])
                    ->native(false)
                    ->query(function (Builder $query, array $data) {
                        if (($data['value'] ?? null) === 'null') {
                            return $query->whereNull('r_caring_status');
                        }

                        return $query->when(
                            $data['value'] ?? null,
                            fn(Builder $query, $value) => $query->where('r_caring_status', $value)
                        );
                    }),

                // ✅ FILTER KETERANGAN (opsi dari tabel keterangans.nama, filter ke pelanggans.keterangan)
                Tables\Filters\SelectFilter::make('keterangan')
                    ->label('Keterangan')
                    ->options(
                        fn() => Keterangan::query()
                        ->whereNotNull('nama')
                        ->where('nama', '!=', '')
                        ->orderBy('nama')
                        ->pluck('nama', 'nama')
                        ->toArray()
                    )
                    ->searchable()
                    ->native(false)
                    ->query(
                        fn(Builder $query, array $data)
                        => $query->when(
                            $data['value'] ?? null,
                            fn(Builder $query, $value) => $query->where('keterangan', $value)
                        )
                    ),
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
