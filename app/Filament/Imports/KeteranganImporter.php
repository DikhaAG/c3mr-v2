<?php

namespace App\Filament\Imports;

use App\Models\Keterangan;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class KeteranganImporter extends Importer
{
    protected static ?string $model = Keterangan::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nama')
                ->label('keterangan')
                ->requiredMapping()
                ->rules(['required', 'max:100']),
        ];
    }

    public function resolveRecord(): ?Keterangan
    {
        return Keterangan::firstOrNew([
            'nama' => $this->data['nama'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your keterangan import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
