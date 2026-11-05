<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket {{ $registration->registration_code }} - MRP Fun Run 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Memaksa browser untuk mencetak semua warna background dan grafis secara presisi */
        html, body {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        @media print {
            /* Menyembunyikan elemen navigasi dan tombol saat dicetak */
            .no-print { 
                display: none !important; 
            }
            
            /* Menghapus teks URL dan Tanggal bawaan browser di tepi kertas */
            @page {
                margin: 0;
            }

            /* Mencegah tiket menempel di tepi kertas saat dicetak tanpa margin */
            body {
                padding: 2cm !important;
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-900 to-gray-900 text-gray-800 font-sans antialiased min-h-screen py-12 px-4">

    <div class="max-w-xl mx-auto">
        
        <div class="flex justify-between items-center mb-6 no-print">
            <a href="{{ route('home') }}" class="text-white hover:text-blue-300 font-semibold flex items-center transition">
                <span class="mr-2">&larr;</span> Kembali ke Beranda
            </a>
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-full shadow transition transform hover:-translate-y-0.5">
                🖨️ Cetak / Simpan PDF
            </button>
        </div>

        <div class="ticket-card bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
            
            <div class="bg-blue-600 text-white p-6 text-center relative">
                <div class="absolute top-0 left-0 w-16 h-16 bg-blue-500 rounded-br-full opacity-40"></div>
                
                <h1 class="text-2xl font-extrabold tracking-widest uppercase">MRP FUN RUN 2026</h1>
                <p class="text-xs uppercase tracking-wider text-blue-100 mt-1">E-Ticket Resmi Peserta • Kabupaten Jeneponto</p>
            </div>

            <div class="p-8 space-y-6">
                
                <div class="text-center bg-gray-50 border border-gray-200 rounded-2xl py-4">
                    <p class="text-xs text-gray-400 font-bold uppercase tracking-wider mb-1">KODE REKENING / BOOKING</p>
                    <p class="text-3xl font-mono font-black text-gray-900 tracking-widest">{{ $registration->registration_code }}</p>
                </div>

                <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-sm">
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase">Nama Lengkap</p>
                        <p class="font-bold text-gray-900 text-base mt-0.5">{{ $registration->full_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase">Nomor Identitas (KTP)</p>
                        <p class="font-bold text-gray-900 text-base mt-0.5">{{ $registration->identity_number }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase">Kategori Lomba</p>
                        <span class="inline-block bg-blue-100 text-blue-800 font-extrabold px-3 py-0.5 rounded text-sm mt-1">
                            {{ str_contains(strtoupper($registration->ticket_category), 'FINISHER') ? $registration->ticket_category : $registration->ticket_category . ' Regular' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase">Ukuran Jersey</p>
                        <p class="font-bold text-gray-900 text-base mt-0.5">{{ $registration->jersey_size ?: '-' }}</p>
                    </div>
                    <div class="text-xs font-bold text-gray-400 uppercase">Nomor BIB (Race Number)</div>
    <div class="text-2xl font-black text-blue-700 uppercase">
        {{ $registration->bib_number ? sprintf('%04d', $registration->bib_number) : 'MENUNGGU' }}
    </div>
                </div>
            </div>

            <div class="relative flex items-center justify-between px-2">
                <div class="w-6 h-6 bg-blue-900 rounded-full -ml-5 border border-transparent"></div>
                <div class="w-full border-t-2 border-dashed border-gray-300 my-1"></div>
                <div class="w-6 h-6 bg-blue-900 rounded-full -mr-5 border border-transparent"></div>
            </div>

            <div class="p-8 bg-gray-50 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="text-center sm:text-left space-y-2">
                    <p class="text-sm font-bold text-gray-800">Selesai & Terverifikasi</p>
                    <p class="text-xs text-gray-500 leading-relaxed max-w-xs">Bawa e-ticket ini (cetak atau via HP) ke lokasi penukaran untuk ditukarkan dengan BIB, Jersey, dan paket Racepack.</p>
                    <div class="inline-flex items-center text-xs text-green-600 font-bold bg-green-50 px-3 py-1 rounded-full border border-green-200 mt-2">
                        <span class="w-2 h-2 rounded-full bg-green-500 mr-2 animate-ping"></span> STATUS: PAID / LUNAS
                    </div>
                </div>
                
                <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-sm flex-shrink-0">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=130x130&data={{ $registration->registration_code }}" 
                         alt="QR Code Tiket" 
                         class="w-32 h-32">
                </div>
            </div>
            
            <div class="bg-gray-900 text-gray-500 text-center py-3 text-xs tracking-wider border-t border-gray-800">
                Harap Datang Tepat Waktu Sesuai Jadwal Event
            </div>
        </div>
        
    </div>

</body>
</html>