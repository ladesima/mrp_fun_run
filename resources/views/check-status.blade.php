<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Pendaftaran - MRP Run 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased min-h-screen flex items-center justify-center py-10 px-4">

    <div class="max-w-md w-full">
        <div class="mb-6 text-center">
            <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm flex items-center justify-center transition">
                &larr; Kembali ke Beranda
            </a>
        </div>

        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            <div class="bg-blue-600 p-6 text-center">
                <h1 class="text-2xl font-extrabold text-white uppercase tracking-wider">Cari Tiket Saya</h1>
                <p class="text-blue-100 text-sm mt-2">Lanjutkan pembayaran atau unduh E-Ticket Anda.</p>
            </div>

            <div class="p-8">
                @if(session('error'))
                    <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm mb-6 font-semibold border border-red-100 text-center">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('find.ticket') }}" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nomor WhatsApp / NIK (KTP)</label>
                        <input type="text" name="search_key" required placeholder="Contoh: 081234567890" class="w-full px-5 py-4 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition text-center font-bold text-lg">
                        <p class="text-xs text-gray-500 mt-2 text-center">Masukkan salah satu data yang Anda gunakan saat mendaftar.</p>
                    </div>
                    
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-black py-4 rounded-xl shadow-lg hover:shadow-xl transform transition hover:-translate-y-1 text-lg uppercase tracking-wider">
                        Cek Status & Tiket
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>