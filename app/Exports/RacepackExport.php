<?php

namespace App\Exports;

use App\Models\Registration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class RacepackExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $hasCollectorRel = method_exists(Registration::class, 'racepackCollector');

        // HANYA data peserta yang sudah LUNAS
        $query = Registration::where('payment_status', 'paid');
        if ($hasCollectorRel) {
            $query->with('racepackCollector');
        }

        // Filter Pencarian
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('registration_code', 'like', "%{$search}%")
                  ->orWhere('bib_number', 'like', "%{$search}%")
                  ->orWhere('identity_number', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Filter Status Pengambilan
        if (!empty($this->filters['status'])) {
            if ($this->filters['status'] === 'collected') {
                $query->where('is_racepack_collected', true);
            } elseif ($this->filters['status'] === 'uncollected') {
                $query->where('is_racepack_collected', false);
            }
        }

        // Filter Ukuran Jersey
        if (!empty($this->filters['jersey_size'])) {
            $query->where('jersey_size', $this->filters['jersey_size']);
        }

        // Filter Petugas
        if (!empty($this->filters['collector_id'])) {
            $query->where('racepack_collected_by', $this->filters['collector_id']);
        }

        // Urutkan Data
        if (!empty($this->filters['sort_by'])) {
            if ($this->filters['sort_by'] === 'jersey_asc') {
                $query->orderBy('jersey_size', 'asc')->orderBy('bib_number', 'asc');
            } elseif ($this->filters['sort_by'] === 'jersey_desc') {
                $query->orderBy('jersey_size', 'desc')->orderBy('bib_number', 'asc');
            } elseif ($this->filters['sort_by'] === 'bib_asc') {
                $query->orderBy('bib_number', 'asc');
            } else {
                $query->orderByDesc('is_racepack_collected')->orderByDesc('racepack_collected_at')->orderBy('bib_number', 'asc');
            }
        } else {
            $query->orderByDesc('is_racepack_collected')->orderBy('jersey_size', 'asc')->orderBy('bib_number', 'asc');
        }

        return $query->get();
    }

    public function map($registration): array
    {
        $hasCollectorRel = method_exists(Registration::class, 'racepackCollector');
        $collectorName = '-';
        if ($hasCollectorRel && $registration->racepackCollector) {
            $collectorName = $registration->racepackCollector->name;
        } elseif ($registration->racepack_collected_by) {
            $collectorName = \App\Models\User::find($registration->racepack_collected_by)?->name ?? ('Admin #' . $registration->racepack_collected_by);
        }

        $waktuAmbil = '-';
        if ($registration->racepack_collected_at) {
            $waktuAmbil = \Carbon\Carbon::parse($registration->racepack_collected_at)->timezone('Asia/Makassar')->format('d/m/Y H:i') . ' WITA';
        }

        return [
            $registration->bib_number ? "'" . sprintf('%04d', $registration->bib_number) : '-',
            $registration->registration_code,
            strtoupper($registration->full_name),
            $registration->identity_number ? "'" . $registration->identity_number : '-',
            $registration->address ?: '-',
            $registration->ticket_category,
            strtoupper($registration->jersey_size ?: '-'),
            $registration->is_racepack_collected ? 'SUDAH DIAMBIL' : 'BELUM DIAMBIL',
            $waktuAmbil,
            $collectorName,
            $registration->community ?: '-',
            "'" . $registration->whatsapp,
            strtoupper($registration->payment_status == 'paid' ? 'LUNAS' : 'PENDING'),
        ];
    }

    public function headings(): array
    {
        return [
            'Nomor BIB',
            'Kode Booking',
            'Nama Lengkap Peserta',
            'NIK KTP',
            'Alamat Domisili',
            'Kategori Lari',
            'UKURAN JERSEY',
            'Status Racepack',
            'Waktu Ambil Racepack',
            'Petugas Verifikator',
            'Komunitas / Instansi',
            'Nomor WhatsApp',
            'Status Pembayaran',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();
        $tableRange = 'A1:' . $lastColumn . $lastRow;

        $sheet->getStyle($tableRange)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Style Kolom Ukuran Jersey (Kolom G) dan Status Racepack (Kolom H) agar jelas & mencolok
        if ($lastRow > 1) {
            $sheet->getStyle('A2:A' . $lastRow)->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);
            $sheet->getStyle('D2:D' . $lastRow)->applyFromArray([
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);
            $sheet->getStyle('G2:G' . $lastRow)->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);
            $sheet->getStyle('H2:H' . $lastRow)->applyFromArray([
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);
        }

        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 11],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1E40AF']], // Navy Blue
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}