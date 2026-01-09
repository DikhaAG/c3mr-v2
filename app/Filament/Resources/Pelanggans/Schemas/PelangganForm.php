<?php

namespace App\Filament\Resources\Pelanggans\Schemas;

use App\Models\Branch;
use App\Models\Fungsi;
use App\Models\Tim;
use App\Models\RCaringStatus;
use App\Models\Keterangan;
use App\Models\Regional;
use App\Models\StatusBayar;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class PelangganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            /* ======================================================
             * DATA IDENTITAS
             * ====================================================== */
            Section::make('Data Identitas')
                ->schema([
                    DatePicker::make('tanggal'),
                    TextInput::make('id_pelanggan'),
                    TextInput::make('nama_pelanggan'),
                    TextInput::make('cp')->label('No. HP / CP'),
                ])
                ->columns(4),

            /* ======================================================
             * DATA LOKASI & SEGMENTASI
             * ====================================================== */
            Section::make('Lokasi & Segmentasi')
                ->schema([
                    TextInput::make('domisili'),
                    Select::make('regional')
                        ->options(fn() => Regional::pluck('nama', 'nama'))
                        ->searchable(),
                    Select::make('branch')
                        ->options(fn() => Branch::pluck('nama', 'nama'))
                        ->searchable(),
                    TextInput::make('sto'),

                    // ⬇️ DIUBAH: dari TextInput → Select dengan bucket LOS
                    Select::make('los')
                        ->label('LOS')
                        ->options([
                            '0-3'   => '0–3 Bulan',
                            '4-6'   => '4–6 Bulan',
                            '7-12'  => '7–12 Bulan',
                            '12-24' => '12–24 Bulan',
                            '24+'   => '>24 Bulan',
                        ])
                        ->native(false) // ⬅️ dropdown modern (bukan <select> HTML biasa)
                        ->searchable(), // ⬅️ UX lebih enak kalau opsi makin banyak

                    TextInput::make('habit_category'),
                ])
                ->columns(3),

            /* ======================================================
             * DATA TAGIHAN
             * ====================================================== */
            Section::make('Data Tagihan')
                ->schema([
                    TextInput::make('category_billing'),
                    TextInput::make('total_tagihan')
                        ->numeric()
                        ->prefix('Rp'),
                    DatePicker::make('tgl_aktivasi'),
                    DatePicker::make('payment_date'),
                    TextInput::make('payment_amount')
                        ->numeric()
                        ->prefix('Rp'),
                    TextInput::make('channel_bayar'),
                ])
                ->columns(3),

            /* ======================================================
             * STATUS & TINDAKAN
             * ====================================================== */
            Section::make('Status & Tindakan')
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

                    TextInput::make('keterangan2'),
                    /* Select::make('paket') */
                    /*     ->options(fn() => Paket::pluck('nama', 'nama')) */
                    /*     ->searchable(), */

                    Select::make('status_bayar')
                        ->options(fn() => StatusBayar::pluck('nama', 'nama'))
                        ->searchable(),

                    TextInput::make('status'),
                ])
                ->columns(3),

        ]);
    }
}
