<?php

namespace App\Filament\Imports;

use App\Models\DataBayar;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class DataBayarImporter extends Importer
{
    protected static ?string $model = DataBayar::class;
    protected static int $chunkSize = 100;
    public static function getColumns(): array
    {
        return [
            ImportColumn::make('bb_id')
                ->rules(['max:255']),
            ImportColumn::make('account_number')
                ->rules(['max:255']),
            ImportColumn::make('telp_number')
                ->rules(['max:255']),
            /* ImportColumn::make('bill_amount_1') */
            /*     ->requiredMapping() */
            /*     ->numeric() */
            /*     ->rules(['required', 'integer']), */
            ImportColumn::make('bill_amount_1')
                ->rules(['nullable', 'numeric'])
                ->castStateUsing(fn($state) => self::cleanNumber($state)),
            /* ImportColumn::make('jumlah_bayar') */
            /*     ->requiredMapping() */
            /*     ->numeric() */
            /*     ->rules(['required', 'integer']), */
            ImportColumn::make('jumlah_bayar')
                ->rules(['nullable', 'numeric'])
                ->castStateUsing(fn($state) => self::cleanNumber($state)),
            /* ImportColumn::make('payment_date') */
            /*     ->rules(['date']), */
            /* ImportColumn::make('payment_date') */
            /*     ->rules(['nullable', 'date']) // Gunakan 'date' saja, jangan 'date_format' jika tidak pasti */
            /*     ->castStateUsing(fn($state) => ($state === '-' || empty($state)) ? null : $state), */
            ImportColumn::make('payment_date')
                ->rules(['nullable', 'date'])
                ->castStateUsing(fn($state) => self::cleanDate($state)),
            ImportColumn::make('status_tagihan')
                ->rules(['max:255']),
            ImportColumn::make('area')
                ->rules(['max:255']),
            ImportColumn::make('region')
                ->rules(['max:255']),
            ImportColumn::make('branch')
                ->rules(['max:255']),
            ImportColumn::make('city')
                ->rules(['max:255']),
            ImportColumn::make('cluster')
                ->rules(['max:255']),
            ImportColumn::make('sto')
                ->rules(['max:255']),
            ImportColumn::make('wok')
                ->rules(['max:255']),
            ImportColumn::make('agency')
                ->rules(['max:255']),
            ImportColumn::make('los')
                ->rules(['max:255']),
            ImportColumn::make('product')
                ->rules(['max:255']),
            ImportColumn::make('mytsel')
                ->rules(['max:255']),
            ImportColumn::make('segment')
                ->rules(['max:255']),
            /* ImportColumn::make('usage_m2') */
            /*     ->requiredMapping() */
            /*     ->numeric() */
            /*     ->rules(['required', 'integer']), */
            /* ImportColumn::make('usage_m1') */
            /*     ->requiredMapping() */
            /*     ->numeric() */
            /*     ->rules(['required', 'integer']), */
            ImportColumn::make('usage_m2')
                ->rules(['nullable', 'numeric'])
                ->castStateUsing(fn($state) => self::cleanNumber($state)),
            ImportColumn::make('usage_m1')
                ->rules(['nullable', 'numeric'])
                ->castStateUsing(fn($state) => self::cleanNumber($state)),
            /* ImportColumn::make('tiket_open') */
            /*     ->requiredMapping() */
            /*     ->numeric() */
            /*     ->rules(['required', 'integer']), */
            ImportColumn::make('tiket_open')
                ->rules(['nullable', 'numeric'])
                ->castStateUsing(fn($state) => self::cleanNumber($state)),
            /* ImportColumn::make('saldo') */
            /*     ->requiredMapping() */
            /*     ->numeric() */
            /*     ->rules(['required', 'integer']), */
            ImportColumn::make('saldo')
                ->rules(['nullable', 'numeric'])
                ->castStateUsing(fn($state) => self::cleanNumber($state)),
            /* ImportColumn::make('bill_amount_2') */
            /*     ->requiredMapping() */
            /*     ->numeric() */
            /*     ->rules(['required', 'integer']), */
            ImportColumn::make('bill_amount_2')
                ->rules(['nullable', 'numeric'])
                ->castStateUsing(fn($state) => self::cleanNumber($state)),
            /* ImportColumn::make('bucket_1') */
            /*     ->requiredMapping() */
            /*     ->numeric() */
            /*     ->rules(['required', 'integer']), */
            /* ImportColumn::make('bucket_2') */
            /*     ->requiredMapping() */
            /*     ->numeric() */
            /*     ->rules(['required', 'integer']), */
            ImportColumn::make('bucket_1')
                ->rules(['nullable', 'numeric'])
                ->castStateUsing(fn($state) => self::cleanNumber($state)),
            ImportColumn::make('bucket_2')
                ->rules(['nullable', 'numeric'])
                ->castStateUsing(fn($state) => self::cleanNumber($state)),
            ImportColumn::make('status')
                ->rules(['max:255']),
            ImportColumn::make('namaloket')
                ->rules(['max:255']),
            ImportColumn::make('kategoriloket')
                ->rules(['max:255']),
            /* ImportColumn::make('dominan_payday') */
            /*     ->requiredMapping() */
            /*     ->numeric() */
            /*     ->rules(['required', 'integer']), */
            ImportColumn::make('dominan_payday')
                ->rules(['nullable', 'numeric'])
                ->castStateUsing(fn($state) => self::cleanNumber($state)),
            /* ImportColumn::make('last_date_pay') */
            /*     ->requiredMapping() */
            /*     ->numeric() */
            /*     ->rules(['required', 'integer']), */
            ImportColumn::make('last_date_pay')
                ->rules(['nullable', 'numeric'])
                ->castStateUsing(fn($state) => self::cleanNumber($state)),
            ImportColumn::make('customer_segment')
                ->rules(['max:255']),
            /* ImportColumn::make('email') */
            /*     ->rules(['email', 'max:255']), */
            /* ImportColumn::make('email') */
            /*     ->rules(['nullable', 'email']) */
            /*     ->castStateUsing(fn($state) => $state === '-' ? null : $state), */
            ImportColumn::make('email')
                ->rules(['nullable', 'email'])
                ->castStateUsing(fn($state) => ($state === '-' || empty($state)) ? null : $state),
            ImportColumn::make('los_category')
                ->rules(['max:255']),
            ImportColumn::make('customer_category')
                ->rules(['max:255']),
            ImportColumn::make('billing_category')
                ->rules(['max:255']),
            /* ImportColumn::make('speed_category') */
            /*     ->requiredMapping() */
            /*     ->numeric() */
            /*     ->rules(['required', 'integer']), */
            ImportColumn::make('speed_category')
                ->rules(['nullable', 'numeric'])
                ->castStateUsing(fn($state) => self::cleanNumber($state)),
            ImportColumn::make('product_category')
                ->rules(['max:255']),
            ImportColumn::make('full_name')
                ->rules(['max:255']),
            /* ImportColumn::make('propensity_score_cp1') */
            /*     ->requiredMapping() */
            /*     ->numeric() */
            /*     ->rules(['required', 'integer']), */
            ImportColumn::make('propensity_score_cp1')
                ->rules(['nullable', 'numeric'])
                ->castStateUsing(fn($state) => self::cleanNumber($state)),
            ImportColumn::make('crm_address')
                ->rules(['max:255']),
            ImportColumn::make('no_handphone')
                ->rules(['max:255']),
            ImportColumn::make('postal_code')
                ->rules(['max:255']),
            ImportColumn::make('phone_number')
                ->rules(['max:255']),
            ImportColumn::make('install_address')
                ->rules(['max:255']),
            ImportColumn::make('addrs')
                ->rules(['max:255']),
            ImportColumn::make('product_name')
                ->rules(['max:255']),
            /* ImportColumn::make('usage_inet_gb') */
            /*     ->requiredMapping() */
            /*     ->numeric() */
            /*     ->rules(['required', 'integer']), */
            /* ImportColumn::make('usage_inet_gb') */
            /*     ->rules(['nullable', 'numeric']), */
            ImportColumn::make('usage_inet_gb')
                ->rules(['nullable', 'numeric'])
                ->castStateUsing(fn($state) => self::cleanNumber($state)),
            ImportColumn::make('sf_code')
                ->rules(['max:255']),
            ImportColumn::make('channel')
                ->rules(['max:255']),
            ImportColumn::make('referral_code')
                ->rules(['max:255']),
            ImportColumn::make('subchannel_sales')
                ->rules(['max:255']),
            ImportColumn::make('bill_info')
                ->rules(['max:255']),
            /* ImportColumn::make('ps_ts') */
            /*     ->rules(['date']), */
            /* ImportColumn::make('ps_ts') */
            /* ->rules(['nullable', 'date']) */
            /* ->castStateUsing(fn($state) => self::cleanDate($state)), */
            ImportColumn::make('ps_ts')
                ->rules(['nullable', 'date'])
                ->castStateUsing(fn($state) => self::cleanDate($state)),
            ImportColumn::make('arpu_cat')
                ->rules(['max:255']),
            ImportColumn::make('chief_code')
                ->rules(['max:255']),
            ImportColumn::make('chief_name')
                ->rules(['max:255']),
            ImportColumn::make('latitude_echo')
                ->rules(['max:255']),
            ImportColumn::make('longitude_echo')
                ->rules(['max:255']),
            ImportColumn::make('cek_bayar')
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): DataBayar
    {
        return new DataBayar();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your data bayar import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }

    protected static function cleanNumber($value): ?float
    {
        if ($value === '-' || $value === '' || is_null($value)) {
            return 0;
        }

        // 1. Hapus spasi
        $value = trim($value);

        // 2. Jika formatnya "205.350" (titik sebagai ribuan), hapus titiknya
        // Kita hapus titik agar menjadi "205350"
        $cleanValue = str_replace('.', '', $value);

        // 3. Jika ada koma sebagai desimal (misal 205.350,50), ganti jadi titik
        $cleanValue = str_replace(',', '.', $cleanValue);

        // 4. Ambil angka murninya
        $sanitized = filter_var($cleanValue, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        return is_numeric($sanitized) ? (float) $sanitized : 0;
    }

    protected static function cleanDate($value): ?string
    {
        if ($value === '-' || empty($value)) {
            return null;
        }

        try {
            return \Illuminate\Support\Carbon::parse($value)->toDateTimeString();
        } catch (\Exception $e) {
            return null;
        }
    }
}
