<?php

namespace App\Filament\Resources\DataBayars\Pages;

use App\Filament\Imports\DataBayarImporter;
use App\Filament\Resources\DataBayars\DataBayarResource;
use App\Models\DataBayar;
use Carbon\Carbon;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListDataBayars extends ListRecords
{
    protected static string $resource = DataBayarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            ImportAction::make()
                ->importer(DataBayarImporter::class)
                ->label('Import Data Bulanan')
                // Logika Validasi: Cek apakah ada data yang dibuat bulan ini
                ->before(function (ImportAction $action) {
                    $alreadyImported = DataBayar::whereMonth('created_at', Carbon::now()->month)
                        ->whereYear('created_at', Carbon::now()->year)
                        ->exists();

                    if ($alreadyImported) {
                        Notification::make()
                            ->danger()
                            ->title('Gagal Import')
                            ->body('Data untuk bulan ini sudah pernah diimport. Import hanya diperbolehkan sekali sebulan.')
                            ->send();

                        $action->halt(); // Menghentikan proses import
                    }
                }),
        ];
    }
}
