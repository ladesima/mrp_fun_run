<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - MRP Fun Run 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased min-h-screen py-10">

    <div class="max-w-3xl mx-auto px-4">
        
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 shadow-sm" role="alert">
            <strong class="font-bold">Berhasil!</strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-blue-600 uppercase tracking-widest">Pembayaran Tiket</h1>
            <p class="text-gray-500 mt-2 font-medium">Selesaikan pembayaran untuk mengamankan tiket Anda.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden mb-8">
            <div class="bg-gray-900 text-white p-6 flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-400 mb-1">Kode Booking</p>
                    <p class="text-xl font-bold tracking-wider">{{ $registration->registration_code }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-400 mb-1">Status</p>
                    @if($registration->payment_status == 'pending' && $registration->payment_proof == null)
                        <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-bold uppercase shadow">Belum Dibayar</span>
                    @elseif($registration->payment_status == 'pending' && $registration->payment_proof != null)
                        <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-bold uppercase shadow animate-pulse">Menunggu Verifikasi</span>
                    @elseif($registration->payment_status == 'paid')
                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-bold uppercase shadow">Lunas</span>
                    @endif
                </div>
            </div>
            
            <div class="p-6">
                <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-4">
                    <span class="font-semibold text-gray-600">Nama Peserta</span>
                    <span class="font-bold text-gray-900">{{ $registration->full_name }}</span>
                </div>
                <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-4">
                    <span class="font-semibold text-gray-600">Kategori Tiket</span>
                    <span class="font-bold text-blue-600">{{ $registration->ticket_category }}</span>
                </div>
                <div class="flex justify-between items-center text-lg">
                    <span class="font-bold text-gray-800">Total Pembayaran</span>
                    <span class="font-extrabold text-2xl text-blue-600">Rp{{ number_format($registration->price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        @if($registration->payment_status == 'pending' && $registration->payment_proof == null)
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-8 rounded-r-xl shadow-sm">
            <div class="flex items-start">
                <div class="flex-shrink-0 mt-0.5">
                    <svg class="h-6 w-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="ml-3 w-full">
                    <h3 class="text-sm font-bold text-yellow-800 uppercase tracking-wide">Pemberitahuan Penting</h3>
                    <div class="mt-3 text-sm text-yellow-800 leading-relaxed space-y-3">
                        <p class="flex items-start">
                            <span class="font-bold mr-2">1.</span> 
                            <span>Data dan kuota tiket Anda <b>hanya dijamin</b> setelah Anda melakukan pembayaran dan mengunggah bukti transfer di bawah ini.</span>
                        </p>
                        <p class="flex items-start">
                            <span class="font-bold mr-2">2.</span> 
                            <span>Jika Anda tidak sengaja menutup halaman ini, Anda selalu dapat melanjutkan proses pembayaran melalui menu <b class="bg-yellow-200 px-1 rounded">Cek Status / Tiket</b> di halaman awal website (menggunakan Nomor WA / KTP Anda).</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-2 mb-8">
            <div class="flex space-x-2 bg-gray-100 p-1 rounded-xl mb-4">
                <button id="btn-qris" onclick="switchTab('qris')" class="w-1/2 py-3 text-sm font-bold rounded-lg bg-white shadow text-blue-600 transition-all">
                    Scan QRIS
                </button>
                <button id="btn-transfer" onclick="switchTab('transfer')" class="w-1/2 py-3 text-sm font-bold rounded-lg text-gray-500 hover:text-gray-700 transition-all">
                    Transfer Bank
                </button>
            </div>

            <div class="p-6 pt-2">
                <div id="content-qris" class="text-center block">
    <h3 class="text-lg font-bold mb-2">Pembayaran via QRIS</h3>
    <p class="text-sm text-gray-500 mb-6">
        Scan QR Code Bank Sulselbar di bawah ini menggunakan aplikasi
        M-Banking atau e-Wallet (Gopay, OVO, Dana, dll).
    </p>

    <!-- QRIS Bank Sulselbar -->
    <div class="inline-block p-1.5 bg-white border-2 border-dashed border-blue-400 rounded-2xl shadow-sm mb-4 hover:border-blue-500 transition overflow-hidden">
        <img src="{{ asset('images/Qrissul.jpeg') }}"
             alt="QRIS Bank Sulselbar"
             class="w-64 h-auto mx-auto rounded-xl object-cover">
    </div>

    <p class="text-sm font-semibold text-blue-700 mb-6">
        QRIS Bank Sulselbar
    </p>

    <!-- Nominal -->
    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6">
        <p class="text-sm text-gray-600 mb-1">Transfer tepat sebesar:</p>
        <p class="font-extrabold text-blue-700 text-2xl">
            Rp{{ number_format($registration->price, 0, ',', '.') }}
        </p>
    </div>

    <!-- Upload bukti -->
    <form action="{{ route('payment.upload', $registration->registration_code) }}"
          method="POST"
          enctype="multipart/form-data"
          class="text-left border-t border-gray-100 pt-6">
        @csrf

        <label class="block text-sm font-semibold text-gray-700 mb-2">
            Upload Bukti Screenshot QRIS (Maks 2 mb)
            <span class="text-red-500">*</span>
        </label>

        <input type="file"
               name="payment_proof"
               required
               accept="image/*"
               class="w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-4
                      file:rounded-full file:border-0 file:text-sm file:font-semibold
                      file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100
                      border border-gray-200 rounded-full mb-4 cursor-pointer">

        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-full transition duration-300 shadow-md">
            Kirim Bukti Pembayaran
        </button>
    </form>
</div>

                <div id="content-transfer" class="hidden">
                    <h3 class="text-lg font-bold mb-4 text-center">Transfer Bank Manual</h3>
                    
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-5 mb-6 text-center">
    <p class="text-sm text-gray-600 mb-4">
        Transfer tepat sebesar
        <strong class="text-blue-600 text-lg">
            Rp{{ number_format($registration->price, 0, ',', '.') }}
        </strong>
        ke salah satu rekening berikut:
    </p>

    <!-- Bank Sulselbar -->
    <div class="bg-white rounded-xl border p-4 mb-4">
        <p class="font-bold text-lg text-gray-800">Bank Sulselbar</p>

        <div class="flex items-center justify-center gap-3 my-2">
            <p id="rek-sulselbar"
               class="text-xl font-mono font-black text-blue-700">
                0202130000000023
            </p>

            <button type="button"
                    onclick="copyRekening('rek-sulselbar')"
                    class="bg-white border border-blue-200 hover:bg-blue-100 text-blue-600 p-2 rounded-lg shadow-sm">
                📋
            </button>
        </div>

        <p class="text-sm text-gray-500">
            a.n Nurhutomo Arif (Bendahara Panitia MRP Fun Run 2026)
        </p>
    </div>

    <!-- Bank Mandiri -->
    <!--<div class="bg-white rounded-xl border p-4">-->
    <!--    <p class="font-bold text-lg text-gray-800">Bank Mandiri</p>-->

    <!--    <div class="flex items-center justify-center gap-3 my-2">-->
    <!--        <p id="rek-mandiri"-->
    <!--           class="text-xl font-mono font-black text-blue-700">-->
    <!--            1740012572079-->
    <!--        </p>-->

    <!--        <button type="button"-->
    <!--                onclick="copyRekening('rek-mandiri')"-->
    <!--                class="bg-white border border-blue-200 hover:bg-blue-100 text-blue-600 p-2 rounded-lg shadow-sm">-->
    <!--            📋-->
    <!--        </button>-->
    <!--    </div>-->

    <!--    <p class="text-sm text-gray-500">-->
    <!--        a.n Nurhutomo Arif (Bendahara Panitia MRP Fun Run 2026)-->
    <!--    </p>-->
    <!--</div>-->

    <p id="copy-toast"
       class="text-sm text-green-600 font-bold hidden mt-4">
        ✅ Nomor rekening berhasil disalin!
    </p>
</div>

                    <form action="{{ route('payment.upload', $registration->registration_code) }}" method="POST" enctype="multipart/form-data" class="text-left border-t border-gray-100 pt-6">
                        @csrf
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Bukti Transfer Bank <span class="text-red-500">*</span></label>
                        <input type="file" name="payment_proof" required accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-3 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-200 rounded-full mb-4 cursor-pointer">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-full transition duration-300 shadow-md">
                            Kirim Bukti Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif

        @if($registration->payment_status == 'pending' && $registration->payment_proof != null)
        <div class="bg-white rounded-2xl shadow-lg border border-blue-100 p-8 text-center mb-8">
            <div class="inline-block relative w-24 h-24 mb-6">
                <svg class="animate-spin text-blue-500 w-full h-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
            
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Menunggu Verifikasi Admin</h3>
            <p class="text-gray-500 mb-6 max-w-md mx-auto">Bukti pembayaran Anda telah kami terima dan saat ini sedang dalam antrean pengecekan oleh panitia kami.</p>
            
            <div class="bg-blue-50 border border-blue-100 text-blue-700 text-sm font-semibold py-3 px-6 rounded-lg inline-flex items-center gap-2">
                <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Silakan muat ulang (refresh) halaman ini secara berkala atau cek status pembayaran anda di tampilan awal website.
            </div>
            
            <div class="mt-8">
                <button onclick="window.location.reload();" class="bg-gray-900 hover:bg-black text-white font-bold py-3 px-8 rounded-full shadow transition">
                    🔄 Refresh Halaman
                </button>
            </div>
        </div>
        @endif

        @if($registration->payment_status == 'paid')
            <div class="bg-white rounded-2xl shadow-lg border border-green-100 p-8 text-center mb-8">
                <div class="w-20 h-20 bg-green-100 text-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h3 class="text-3xl font-black text-gray-800 mb-2">Pembayaran Berhasil!</h3>
                <p class="text-gray-500 mb-8 font-medium">Terima kasih, pembayaran tiket Anda telah divalidasi oleh sistem.</p>
                <a href="{{ route('ticket.show', $registration->registration_code) }}" class="inline-block w-full sm:w-auto px-10 text-center bg-green-500 hover:bg-green-600 text-white font-black tracking-wide uppercase py-4 rounded-full shadow-lg hover:shadow-xl hover:-translate-y-1 transform transition duration-300 text-lg">
                    🎟️ Lihat & Unduh E-Ticket
                </a>
            </div>
        @endif

    </div>

    <script>
        // Logika Perpindahan Tab
        function switchTab(tab) {
            const btnQris = document.getElementById('btn-qris');
            const btnTransfer = document.getElementById('btn-transfer');
            const contentQris = document.getElementById('content-qris');
            const contentTransfer = document.getElementById('content-transfer');

            if (tab === 'qris') {
                contentQris.classList.remove('hidden');
                contentTransfer.classList.add('hidden');
                
                btnQris.className = 'w-1/2 py-3 text-sm font-bold rounded-lg bg-white shadow text-blue-600 transition-all';
                btnTransfer.className = 'w-1/2 py-3 text-sm font-bold rounded-lg text-gray-500 hover:text-gray-700 transition-all';
            } else {
                contentTransfer.classList.remove('hidden');
                contentQris.classList.add('hidden');
                
                btnTransfer.className = 'w-1/2 py-3 text-sm font-bold rounded-lg bg-white shadow text-blue-600 transition-all';
                btnQris.className = 'w-1/2 py-3 text-sm font-bold rounded-lg text-gray-500 hover:text-gray-700 transition-all';
            }
        }
        function switchQris(bank) {
    const sulselbar = document.getElementById('qris-sulselbar');
    const mandiri = document.getElementById('qris-mandiri');

    const btnSulselbar = document.getElementById('btn-qris-sulselbar');
    const btnMandiri = document.getElementById('btn-qris-mandiri');

    if (bank === 'sulselbar') {
        sulselbar.classList.remove('hidden');
        mandiri.classList.add('hidden');

        btnSulselbar.className = 'px-5 py-2 rounded-lg bg-white shadow text-blue-600 font-semibold transition';
        btnMandiri.className = 'px-5 py-2 rounded-lg text-gray-600 hover:text-gray-800 transition';
    } else {
        mandiri.classList.remove('hidden');
        sulselbar.classList.add('hidden');

        btnMandiri.className = 'px-5 py-2 rounded-lg bg-white shadow text-blue-600 font-semibold transition';
        btnSulselbar.className = 'px-5 py-2 rounded-lg text-gray-600 hover:text-gray-800 transition';
    }
}
        // Logika Copy Text (Salin Rekening)
        function copyRekening(elementId) {
    const rekNumber = document.getElementById(elementId).innerText.trim();

    navigator.clipboard.writeText(rekNumber).then(() => {
        const toast = document.getElementById('copy-toast');
        toast.classList.remove('hidden');

        setTimeout(() => {
            toast.classList.add('hidden');
        }, 3000);
    }).catch(() => {
        alert('Gagal menyalin nomor rekening. Silakan salin manual.');
    });
}
    </script>
</body>
</html>