<?php

namespace App\Filament\Resources\DataBayars\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DataBayarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('bb_id'),
                TextInput::make('account_number'),
                TextInput::make('telp_number')
                    ->tel(),
                TextInput::make('bill_amount_1')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('jumlah_bayar')
                    ->required()
                    ->numeric()
                    ->default(0),
                DatePicker::make('payment_date'),
                TextInput::make('status_tagihan'),
                TextInput::make('area'),
                TextInput::make('region'),
                TextInput::make('branch'),
                TextInput::make('city'),
                TextInput::make('cluster'),
                TextInput::make('sto'),
                TextInput::make('wok'),
                TextInput::make('agency'),
                TextInput::make('los'),
                TextInput::make('product'),
                TextInput::make('mytsel'),
                TextInput::make('segment'),
                TextInput::make('usage_m2')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('usage_m1')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('tiket_open')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('saldo')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('bill_amount_2')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('bucket_1')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('bucket_2')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('status'),
                TextInput::make('namaloket'),
                TextInput::make('kategoriloket'),
                TextInput::make('dominan_payday')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('last_date_pay')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('customer_segment'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('los_category'),
                TextInput::make('customer_category'),
                TextInput::make('billing_category'),
                TextInput::make('speed_category')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('product_category'),
                TextInput::make('full_name'),
                TextInput::make('propensity_score_cp1')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('crm_address'),
                TextInput::make('no_handphone')
                    ->tel(),
                TextInput::make('postal_code'),
                TextInput::make('phone_number')
                    ->tel(),
                TextInput::make('install_address'),
                TextInput::make('addrs'),
                TextInput::make('product_name'),
                TextInput::make('usage_inet_gb')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('sf_code'),
                TextInput::make('channel'),
                TextInput::make('referral_code'),
                TextInput::make('subchannel_sales'),
                TextInput::make('bill_info'),
                DateTimePicker::make('ps_ts'),
                TextInput::make('arpu_cat'),
                TextInput::make('chief_code'),
                TextInput::make('chief_name'),
                TextInput::make('latitude_echo'),
                TextInput::make('longitude_echo'),
                TextInput::make('cek_bayar'),
            ]);
    }
}
