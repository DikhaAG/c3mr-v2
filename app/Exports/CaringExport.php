<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class CaringExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    protected $data;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        $finalRows = collect();
        $grandTotal = 0;

        // Grouping berdasarkan Tanggal (created_at)
        $perTanggal = $this->data->groupBy('tanggal');

        foreach ($perTanggal as $tgl => $dataTgl) {
            $totalPerTgl = 0;

            // Grouping berdasarkan Petugas (Admin)
            $perAdmin = $dataTgl->groupBy('admin');

            foreach ($perAdmin as $admin => $items) {
                $totalPerAdmin = 0;
                foreach ($items as $item) {
                    $finalRows->push([
                        'tgl' => \Carbon\Carbon::parse($tgl)->format('d/m/Y'),
                        'petugas' => $admin,
                        'hasil' => $item->keterangan ?? '-',
                        'count' => $item->total,
                    ]);
                    $totalPerAdmin += $item->total;
                }
                // Baris Sub-total Petugas (Contoh: salsa Total)
                $finalRows->push([
                    'tgl' => '',
                    'petugas' => "$admin Total",
                    'hasil' => '',
                    'count' => $totalPerAdmin,
                ]);
                $totalPerTgl += $totalPerAdmin;
            }

            // Baris Sub-total Tanggal (Contoh: 06/10/2025 Total)
            $finalRows->push([
                'tgl' => \Carbon\Carbon::parse($tgl)->format('d/m/Y') . " Total",
                'petugas' => '',
                'hasil' => '',
                'count' => $totalPerTgl,
            ]);

            $grandTotal += $totalPerTgl;
        }

        // Baris Paling Akhir: Grand Total
        $finalRows->push([
            'tgl' => 'Grand Total',
            'petugas' => '',
            'hasil' => '',
            'count' => $grandTotal,
        ]);

        return $finalRows;
    }

    public function headings(): array
    {
        return [
            ['Data Caring'], // Baris 1: Judul
            ['tgl caring', 'petugas', 'Hasil Caring', 'COUNT hasil caring'], // Baris 2: Header Tabel
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Styling untuk mempercantik Excel
        $highestRow = $sheet->getHighestRow();

        return [
            1 => ['font' => ['bold' => true, 'size' => 14]], // Judul "Data Caring"
            2 => ['font' => ['bold' => true]],               // Header Tabel
            "A1:D$highestRow" => [
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
            ],
        ];
    }
}
