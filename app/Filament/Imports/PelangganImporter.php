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
                ->rules(['date']),
            ImportColumn::make('id_pelanggan')
                ->rules(['max:255']),
            ImportColumn::make('domisili')
                ->rules(['max:255']),
            ImportColumn::make('category_billing')
                ->rules(['max:255']),
            ImportColumn::make('nama_pelanggan')
                ->rules(['max:255']),
            ImportColumn::make('cp')
                ->rules(['max:255']),
            ImportColumn::make('branch')
                ->rules(['max:255']),
            ImportColumn::make('sto')
                ->rules(['max:255']),
            ImportColumn::make('los')
                ->rules(['max:255']),
            ImportColumn::make('status')
                ->rules(['max:255']),
            ImportColumn::make('habit_category')
                ->rules(['max:255']),
            ImportColumn::make('total_tagihan')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('fungsi')
                ->rules(['max:255']),
            ImportColumn::make('admin')
                ->rules(['max:255']),
            ImportColumn::make('r_caring_status')
                ->rules(['max:255']),
            ImportColumn::make('keterangan')
                ->rules(['max:255']),
            ImportColumn::make('paket')
                ->rules(['max:255']),
            ImportColumn::make('tgl_aktivasi')
                ->rules(['date']),
            ImportColumn::make('status_bayar')
                ->rules(['max:255']),
            ImportColumn::make('payment_date')
                ->rules(['date']),
            ImportColumn::make('payment_amount')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('channel_bayar')
                ->rules(['max:255']),
            ImportColumn::make('regional')
                ->rules(['max:100']),
        ];
    }

    public function resolveRecord(): Pelanggan
    {
        return new Pelanggan();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your pelanggan import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
