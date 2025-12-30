<?php

namespace App\Filament\Imports;

use App\Models\Pelanggan;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class PelangganImporter extends Importer
{
    protected static ?string $model = Pelanggan::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('tanggal')
                ->label('TANGGAL')
                ->rules(['required', 'date']),

            ImportColumn::make('id_pelanggan')
                ->label('SND')
                ->requiredMapping()
                ->rules(['required', 'max:255']),

            ImportColumn::make('domisili')
                ->label('WOK')
                ->rules(['max:255']),

            ImportColumn::make('category_billing')
                ->label('CATEGORY BILLING')
                ->rules(['max:255']),

            ImportColumn::make('nama_pelanggan')
                ->label('NAMA PELANGGAN')
                ->rules(['max:255']),

            ImportColumn::make('cp')
                ->label('CP')
                ->rules(['max:255']),

            ImportColumn::make('branch')
                ->label('BRANCH')
                ->rules(['max:255']),

            ImportColumn::make('sto')
                ->label('STO')
                ->rules(['max:255']),

            ImportColumn::make('los')
                ->label('LOS')
                ->rules(['max:255']),

            ImportColumn::make('status')
                ->label('STATUS')
                ->rules(['max:255']),

            ImportColumn::make('habit_category')
                ->label('HABIT CATEGORY')
                ->rules(['max:255']),

            ImportColumn::make('total_tagihan')
                ->label('TOTAL TAGIHAN')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'numeric']),

            ImportColumn::make('fungsi')
                ->label('FUNGSI')
                ->rules(['max:255']),

            ImportColumn::make('admin')
                ->label('ADMIN')
                ->rules(['max:255']),

            ImportColumn::make('r_caring_status')
                ->label('R_CARING_STATUS')
                ->rules(['max:255']),

            ImportColumn::make('keterangan')
                ->label('KETERANGAN')
                ->rules(['max:255']),

            ImportColumn::make('paket')
                ->label('PAKET')
                ->rules(['max:255']),

            ImportColumn::make('tgl_aktivasi')
                ->label('TGL_AKTIVASI')
                ->rules(['nullable', 'date']),

            ImportColumn::make('status_bayar')
                ->label('STATUS BAYAR')
                ->rules(['max:255']),

            ImportColumn::make('payment_date')
                ->label('PAYMENT_DATE 1')
                ->rules(['nullable', 'date']),

            ImportColumn::make('payment_amount')
                ->label('PAYMENT_AMOUNT 1')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'numeric']),

            ImportColumn::make('channel_bayar')
                ->label('CHANEL BAYAR 1')
                ->rules(['max:255']),

            ImportColumn::make('regional')
                ->label('REGIONAL')
                ->rules(['max:100']),
        ];
    }

    public function resolveRecord(): Pelanggan
    {
        $adminName = $this->data['admin'] ?? null;

        if (!empty($adminName)) {
            try {
                \App\Models\Tim::updateOrCreate(
                    ['nama_lengkap' => $adminName], // Cari berdasarkan nama
                    [
                        'username' => $adminName,
                        'regional' => $this->data['regional'] ?? 'SUMBAGSEL',
                        'branch'   => $this->data['branch'] ?? "PALEMBANG",
                    ]
                );
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Gagal buat Tim: " . $e->getMessage());
            }
        }

        $keteranganName = $this->data['keterangan'] ?? null;

        if (!empty($keteranganName)) {
            try {
                \App\Models\Keterangan::updateOrCreate(
                    ['nama' => $keteranganName], // Cari berdasarkan nama
                    [
                        'nama' => $keteranganName,
                    ]
                );
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Gagal buat Keterangan: " . $e->getMessage());
            }
        }

        return new Pelanggan();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Impor pelanggan telah selesai dan ' . Number::format($import->successful_rows) . ' ' . str('baris')->plural($import->successful_rows) . ' berhasil diimpor.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('baris')->plural($failedRowsCount) . ' gagal diimpor.';
        }

        return $body;
    }
}
