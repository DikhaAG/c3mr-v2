<?php

namespace App\Filament\Imports;

use App\Models\Pelanggan;
use App\Models\Tim;
use App\Models\Branch;
use App\Models\Fungsi;
use App\Models\Keterangan;
use App\Models\Keterangan2;
use App\Models\Paket;
use App\Models\Regional;
use App\Models\RCaringStatus;
use App\Models\StatusBayar;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;
use Illuminate\Support\Facades\Log;
use App\Models\Los;

class PelangganImporter extends Importer
{
    protected static ?string $model = Pelanggan::class;

    public static function getColumns(): array
    {
        return [
            // TIDAK DIUBAH
            ImportColumn::make('tanggal')
                ->label('TANGGAL')
                ->guess(['TANGGAL'])
                ->rules(['nullable', 'date']),

            ImportColumn::make('id_pelanggan')
                ->label('SND')
                ->guess(['SND'])
                ->requiredMapping()
                ->rules(['nullable', 'max:255']),

            ImportColumn::make('domisili')
                ->label('WOK')
                ->guess(['WOK'])
                ->rules(['nullable', 'max:255']),

            ImportColumn::make('category_billing')
                ->label('CATEGORY BILLING')
                ->guess(['CATEGORY BILLING'])
                ->rules(['nullable', 'max:255']),

            ImportColumn::make('nama_pelanggan')
                ->label('NAMA PELANGGAN')
                ->guess(['NAMA PELANGGAN'])
                ->rules(['max:255', 'nullable']),

            ImportColumn::make('cp')
                ->label('CP')
                ->guess(['CP'])
                ->rules(['max:255', 'nullable']),

            ImportColumn::make('branch')
                ->label('BRANCH')
                ->guess(['BRANCH'])
                ->rules(['max:255', 'nullable']),

            ImportColumn::make('sto')
                ->label('STO')
                ->guess(['STO'])
                ->rules(['max:255', 'nullable']),

            ImportColumn::make('los')
                ->label('LOS')
                ->guess(['LOS'])
                ->rules(['max:255', 'nullable']),

            ImportColumn::make('status')
                ->label('STATUS')
                ->guess(['STATUS'])
                ->rules(['max:255', 'nullable']),

            ImportColumn::make('habit_category')
                ->label('HABIT CATEGORY')
                ->guess(['HABIT CATEGORY', 'habit_category'])
                ->rules(['max:255', 'nullable']),

            ImportColumn::make('total_tagihan')
                ->label('TOTAL TAGIHAN')
                ->guess(['TOTAL TAGIHAN'])
                ->requiredMapping()
                ->numeric()
                ->rules(['nullable', 'numeric']),

            ImportColumn::make('fungsi')
                ->label('FUNGSI')
                ->guess(['FUNGSI'])
                ->rules(['max:255', 'nullable']),

            ImportColumn::make('admin')
                ->label('ADMIN')
                ->guess(['ADMIN', 'Admin'])
                ->rules(['max:255', 'nullable']),

            ImportColumn::make('r_caring_status')
                ->label('R_CARING_STATUS')
                ->rules(['max:255', 'nullable']),

            ImportColumn::make('keterangan')
                ->label('Keterangan')
                ->rules(['max:255', 'nullable']),

            ImportColumn::make('keterangan2')
                ->label('KETERANGAN2')
                ->rules(['max:255', 'nullable']),

            ImportColumn::make('tgl_aktivasi')
                ->label('TGL AKTIVASI')
                ->guess(['TGL AKTIVASI', 'TGL_AKTIVASI'])
                ->rules(['nullable', 'date']),

            ImportColumn::make('status_bayar')
                ->label('STATUS BAYAR')
                ->guess(['STATUS  BAYAR ', 'STATUS BAYAR'])
                ->rules(['max:255', 'nullable']),

            ImportColumn::make('payment_date')
                ->label('PAYMENT_DATE 1')
                ->guess(['PAYMENT_DATE 1'])
                ->rules(['nullable', 'date']),

            ImportColumn::make('payment_amount')
                ->label('PAYMENT_AMOUNT 1')
                ->guess(['PAYMENT_AMOUNT 1'])
                ->requiredMapping()
                ->numeric()
                ->rules(['numeric', 'nullable']),

            ImportColumn::make('channel_bayar')
                ->label('CHANEL BAYAR 1')
                ->guess(['CHANEL BAYAR 1'])
                ->rules(['max:255', 'nullable']),

            ImportColumn::make('regional')
                ->label('REGIONAL')
                ->guess(['REGIONAL', 'Regional'])
                ->rules(['nullable', 'max:100']), // <-- MODIFIKASI: dibuat nullable agar CSV tanpa regional tidak gagal
        ];
    }

    public function resolveRecord(): Pelanggan
    {
        // ================== MODIFIKASI DIMULAI ==================

        if (
            ! array_key_exists('regional', $this->data) // <-- MODIFIKASI: jika kolom regional tidak ada di CSV
            || $this->clean($this->data['regional'] ?? null) === null // <-- MODIFIKASI: atau ada tapi kosong
        ) {
            $this->data['regional'] = 'SUMBAGSEL'; // <-- MODIFIKASI: set default regional
        }

        // ================== MODIFIKASI SELESAI ==================

        $this->syncMasterDataForRow();

        return new Pelanggan();
    }

    protected function syncMasterDataForRow(): void
    {
        $branch   = $this->clean($this->data['branch'] ?? null);
        $fungsi   = $this->clean($this->data['fungsi'] ?? null);
        $ket      = $this->clean($this->data['keterangan'] ?? null);
        $ket2     = $this->clean($this->data['keterangan2'] ?? null);
        $paket    = $this->clean($this->data['paket'] ?? null);
        $los = $this->normalizeLos($this->data['los'] ?? null);

        $regional = $this->clean($this->data['regional'] ?? null) ?? 'SUMBAGSEL';
        // <-- MODIFIKASI: memastikan regional TIDAK PERNAH null saat dipakai di master data

        // ================== MODIFIKASI SELESAI ==================

        $rcs      = $this->clean($this->data['r_caring_status'] ?? null);
        $sb       = $this->clean($this->data['status_bayar'] ?? null);
        $admin    = $this->clean($this->data['admin'] ?? null);

        try {
            if ($branch) {
                Branch::firstOrCreate(['nama' => $branch]);
            }

            if ($fungsi) {
                Fungsi::firstOrCreate(['nama' => $fungsi]);
            }

            if ($ket) {
                Keterangan::firstOrCreate(['nama' => $ket]);
            }

            if ($ket2) {
                Keterangan2::firstOrCreate(['nama' => $ket2]);
            }

            if ($paket) {
                Paket::firstOrCreate(['nama' => $paket]);
            }

            if ($los) {
                Los::firstOrCreate(['nama' => $los]);
            }

            Regional::firstOrCreate(['nama' => $regional]);

            if ($rcs) {
                RCaringStatus::firstOrCreate(['nama' => $rcs]);
            }

            if ($sb) {
                StatusBayar::firstOrCreate(['nama' => $sb]);
            }

            if ($admin) {
                Tim::updateOrCreate(
                    ['nama_lengkap' => $admin],
                    [
                        'username' => $admin,
                        'regional' => $regional, // <-- MODIFIKASI: sekarang dijamin terisi
                        'branch'   => $branch ?? 'PALEMBANG',
                    ]
                );
            }
        } catch (\Throwable $e) {
            Log::error('Import master data gagal: ' . $e->getMessage(), [
                'row' => $this->data,
            ]);
        }
    }

    protected function clean(?string $value): ?string
    {
        $value = is_string($value) ? trim($value) : $value;
        return ($value === '' || $value === null) ? null : $value;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Impor pelanggan telah selesai dan '
            . Number::format($import->successful_rows)
            . ' '
            . str('baris')->plural($import->successful_rows)
            . ' berhasil diimpor.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '
                . Number::format($failedRowsCount)
                . ' '
                . str('baris')->plural($failedRowsCount)
                . ' gagal diimpor.';
        }

        return $body;
    }

    protected function normalizeLos(?string $value): ?string
    {
        $value = $this->clean($value);
        if (! $value) {
            return null;
        }

        $value = str_replace(["–", "—"], "-", $value);   // samakan dash
        $value = preg_replace('/\s+/', ' ', $value);     // rapikan spasi

        return trim($value);
    }
}
