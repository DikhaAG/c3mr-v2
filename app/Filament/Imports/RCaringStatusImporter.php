<?php

namespace App\Filament\Imports;

use App\Models\RCaringStatus;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class RCaringStatusImporter extends Importer
{
    protected static ?string $model = RCaringStatus::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nama')
                ->label('r_caring_status')
                ->requiredMapping()
                ->rules(['required', 'max:100']),
        ];
    }

    public function resolveRecord(): RCaringStatus
    {
        return RCaringStatus::firstOrNew([
            'nama' => $this->data['nama'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your r caring status import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
