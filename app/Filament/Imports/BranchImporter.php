<?php

namespace App\Filament\Imports;

use App\Models\Branch;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number; // Menggunakan helper Number standar v4/Laravel 12

class BranchImporter extends Importer
{
    protected static ?string $model = Branch::class;

    public static function getColumns(): array
    {
        return [
            // Mempertahankan logic v3: DB 'nama' mengambil dari kolom file 'branch'
            ImportColumn::make('nama')
                ->label('branch')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
        ];
    }

    /**
     * Filament 4 menggunakan return type : ?Branch
     * Mempertahankan logic v3: cek duplikasi berdasarkan kolom 'nama' dari data 'branch'
     */
    public function resolveRecord(): ?Branch
    {
        return Branch::firstOrNew([
            'nama' => $this->data['nama'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        // Menggunakan Number::format sesuai standar v4/Laravel 12
        $body = 'Impor branch telah selesai dan ' . Number::format($import->successful_rows) . ' data berhasil diimpor.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' data gagal diimpor.';
        }

        return $body;
    }
}
