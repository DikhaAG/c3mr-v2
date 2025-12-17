<?php

namespace App\Filament\Resources\Pelanggans\Schemas;

use App\Models\Fungsi;
use App\Models\Tim;
use App\Models\RCaringStatus;
use App\Models\Keterangan;
use App\Models\Paket;
use App\Models\StatusBayar;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section; // Layouting masuk ke Schemas
use Filament\Forms\Components\DatePicker; // Input tetap di Forms
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class PelangganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Section sekarang di-import dari Filament\Schemas\Components
                Section::make('Data Identitas')
                    ->schema([
                        DatePicker::make('tanggal'),
                        TextInput::make('id_pelanggan'),
                        TextInput::make('nama_pelanggan'),
                    ])->columns(3),

                Section::make('Status & Keterangan')
                    ->schema([
                        Select::make('fungsi')
                            ->options(fn() => Fungsi::pluck('nama', 'nama'))
                            ->searchable(),
                        Select::make('admin')
                            ->options(fn() => Tim::pluck('nama_lengkap', 'nama_lengkap'))
                            ->searchable(),
                        Select::make('r_caring_status')
                            ->options(fn() => RCaringStatus::pluck('nama', 'nama'))
                            ->searchable(),
                        Select::make('keterangan')
                            ->options(fn() => Keterangan::pluck('nama', 'nama'))
                            ->searchable(),
                        Select::make('paket')
                            ->options(fn() => Paket::pluck('nama', 'nama'))
                            ->searchable(),
                        Select::make('status_bayar')
                            ->options(fn() => StatusBayar::pluck('nama', 'nama'))
                            ->searchable(),
                    ])->columns(3),
            ]);
    }
}
