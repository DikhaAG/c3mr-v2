<?php

namespace App\Filament\Resources\DataBayars\Tables;

use App\Filament\Imports\DataBayarImporter;
use App\Models\DataBayar;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ImportAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DataBayarsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->headerActions([
                ImportAction::make()
                    ->importer(DataBayarImporter::class),
                /* ->disabled( */
                /*     fn() */
                /*     => DataBayar::query() */
                /*         ->whereMonth('created_at', now()->month) */
                /*         ->whereYear('created_at', now()->year) */
                /*         ->exists() */
                /* ) */
                /* ->tooltip( */
                /*     fn() */
                /*     => DataBayar::query() */
                /*         ->whereMonth('created_at', now()->month) */
                /*         ->whereYear('created_at', now()->year) */
                /*         ->exists() */
                /*     ? 'Import dikunci karena data bayar untuk bulan ini sudah ada' */
                /*     : null */
                /* ), */
            ])
            ->columns([
                TextColumn::make('bb_id')
                    ->searchable(),
                TextColumn::make('account_number')
                    ->searchable(),
                TextColumn::make('telp_number')
                    ->searchable(),
                TextColumn::make('bill_amount_1')
                    ->numeric()
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('jumlah_bayar')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('payment_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('status_tagihan')
                    ->searchable(),
                TextColumn::make('area')
                    ->searchable(),
                TextColumn::make('region')
                    ->searchable(),
                TextColumn::make('branch')
                    ->searchable(),
                TextColumn::make('city')
                    ->searchable(),
                TextColumn::make('cluster')
                    ->searchable(),
                TextColumn::make('sto')
                    ->searchable(),
                TextColumn::make('wok')
                    ->searchable(),
                TextColumn::make('agency')
                    ->searchable(),
                TextColumn::make('los')
                    ->searchable(),
                TextColumn::make('product')
                    ->searchable(),
                TextColumn::make('mytsel')
                    ->searchable(),
                TextColumn::make('segment')
                    ->searchable(),
                TextColumn::make('usage_m2')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('usage_m1')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('tiket_open')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('saldo')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('bill_amount_2')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('bucket_1')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('bucket_2')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('namaloket')
                    ->searchable(),
                TextColumn::make('kategoriloket')
                    ->searchable(),
                TextColumn::make('dominan_payday')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('last_date_pay')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('customer_segment')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('los_category')
                    ->searchable(),
                TextColumn::make('customer_category')
                    ->searchable(),
                TextColumn::make('billing_category')
                    ->searchable(),
                TextColumn::make('speed_category')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('product_category')
                    ->searchable(),
                TextColumn::make('full_name')
                    ->searchable(),
                TextColumn::make('propensity_score_cp1')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('crm_address')
                    ->searchable(),
                TextColumn::make('no_handphone')
                    ->searchable(),
                TextColumn::make('postal_code')
                    ->searchable(),
                TextColumn::make('phone_number')
                    ->searchable(),
                TextColumn::make('install_address')
                    ->searchable(),
                TextColumn::make('addrs')
                    ->searchable(),
                TextColumn::make('product_name')
                    ->searchable(),
                TextColumn::make('usage_inet_gb')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sf_code')
                    ->searchable(),
                TextColumn::make('channel')
                    ->searchable(),
                TextColumn::make('referral_code')
                    ->searchable(),
                TextColumn::make('subchannel_sales')
                    ->searchable(),
                TextColumn::make('bill_info')
                    ->searchable(),
                TextColumn::make('ps_ts')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('arpu_cat')
                    ->searchable(),
                TextColumn::make('chief_code')
                    ->searchable(),
                TextColumn::make('chief_name')
                    ->searchable(),
                TextColumn::make('latitude_echo')
                    ->searchable(),
                TextColumn::make('longitude_echo')
                    ->searchable(),
                TextColumn::make('cek_bayar')
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

                Filter::make('created_at')
                    ->schema([
                        DatePicker::make('created_from')->label('Dibuat Dari'),
                        DatePicker::make('created_until')->label('Dibuat Sampai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['created_from'], fn($q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['created_until'], fn($q, $date) => $q->whereDate('created_at', '<=', $date));
                    }),
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
