<?php

namespace App\Filament\Resources\Pelanggans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PelangganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('tanggal'),
                TextInput::make('id_pelanggan'),
                TextInput::make('domisili'),
                TextInput::make('category_billing'),
                TextInput::make('nama_pelanggan'),
                TextInput::make('cp'),
                TextInput::make('branch'),
                TextInput::make('sto'),
                TextInput::make('los'),
                TextInput::make('status'),
                TextInput::make('habit_category'),
                TextInput::make('total_tagihan')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('fungsi'),
                TextInput::make('admin'),
                TextInput::make('r_caring_status'),
                TextInput::make('keterangan'),
                TextInput::make('paket'),
                DatePicker::make('tgl_aktivasi'),
                TextInput::make('status_bayar'),
                DatePicker::make('payment_date'),
                TextInput::make('payment_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('channel_bayar'),
                TextInput::make('regional'),
            ]);
    }
}
