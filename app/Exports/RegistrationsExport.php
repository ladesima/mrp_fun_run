<?php

namespace App\Exports;

use App\Models\Registration;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize; // Untuk lebar kolom otomatis
use Maatwebsite\Excel\Concerns\WithStyles; // Untuk styling warna dan border
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class RegistrationsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    /**
     * 1. Mengambil seluruh data peserta dari yang paling baru
     */
    public function collection()
    {
        return Registration::latest()->get(); 
    }

    /**
     * 2. Memetakan SELURUH kolom database ke baris Excel secara berurutan
     */
    public function map($registration): array
    {
        return [
            $registration->id,
            $registration->registration_code,
            $registration->full_name,
            $registration->gender,
            $registration->birth_place,
            $registration->birth_date,
            $registration->age . ' Tahun',
            "'" . $registration->whatsapp, 
            $registration->email,
            $registration->address,
            "'" . $registration->identity_number, 
            $registration->ticket_category,
            $registration->bib_number ? "'" . sprintf('%04d', $registration->bib_number) : '-', 
            $registration->bib_name ?: '-',
            'Rp ' . number_format($registration->price, 0, ',', '.'),
            $registration->jersey_size ?: '-',
            $registration->community ?? '-',
            $registration->emergency_name,
            $registration->emergency_relation,
            "'" . $registration->emergency_phone, 
            strtoupper($registration->blood_type ?? '-'),
            $registration->medical_history ?? 'Tidak Ada',
            $registration->health_declaration ? 'Ya' : 'Tidak',
            $registration->terms_agreement ? 'Setuju' : 'Tidak',
            $registration->media_consent ? 'Setuju' : 'Tidak',
            strtoupper($registration->payment_status == 'paid' ? 'LUNAS' : 'PENDING'), 
            $registration->created_at->format('d/m/Y H:i'), // Format waktu diperpendek agar rapi
        ];
    }

    /**
     * 3. Memberikan Judul Kolom (Header)
     */
    public function headings(): array
    {
        return [
            'ID Sistem',
            'Kode Booking',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Usia',
            'Nomor WhatsApp',
            'Email',
            'Alamat Tinggal',
            'Nomor Identitas (NIK KTP)',
            'Kategori Lari',
            'Nomor BIB (Dada)',
            'Nama BIB (Dada)',
            'Biaya Tiket',
            'Ukuran Jersey',
            'Komunitas / Klub',
            'Nama Kontak Darurat',
            'Hubungan',
            'No. Telp Darurat',
            'Golongan Darah',
            'Riwayat Penyakit',
            'Pernyataan Sehat',
            'Persetujuan S&K',
            'Persetujuan Medis',
            'Status Pembayaran',
            'Waktu Mendaftar',
        ];
    }

    /**
     * 4. Memberikan Gaya (Styling) pada Excel
     */
    public function styles(Worksheet $sheet)
    {
        // Mendapatkan baris dan kolom terakhir yang ada datanya
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();
        $tableRange = 'A1:' . $lastColumn . $lastRow;

        // Styling Global (Untuk seluruh tabel)
        $sheet->getStyle($tableRange)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Border hitam tipis
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        return [
            // Styling khusus baris pertama (Header)
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'FFFFFFFF'], // Teks Putih
                    'size' => 12,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF1D4ED8'], // Latar Belakang Biru (Blue-700 Tailwind)
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }
}