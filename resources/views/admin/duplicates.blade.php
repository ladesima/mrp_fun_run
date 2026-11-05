<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Duplikat - MRP Run Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased min-h-screen pb-12">

    <nav class="bg-gray-900 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <span class="text-blue-500 font-bold text-xl tracking-wider uppercase">⚙️ MRP RUN ADMIN</span>
                    <span class="hidden md:inline-block bg-gray-800 text-gray-300 text-xs px-3 py-1 rounded-full border border-gray-700">
                        {{ auth()->user()->name }} ({{ auth()->user()->isSuperadmin() ? '👑 Superadmin' : '🎒 Petugas Racepack' }})
                    </span>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="ml-4 bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2 px-4 rounded transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="mb-8 border-b-2 border-gray-200">
            <nav class="flex space-x-8" aria-label="Tabs">
                <a href="{{ route('admin.dashboard') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-4 py-4 px-1 font-bold text-lg transition">
                    📊 Dashboard & Pembayaran
                </a>
                <a href="{{ route('admin.racepack') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-4 py-4 px-1 font-bold text-lg transition">
                    🎒 Manajemen Racepack
                </a>
                <a href="{{ route('admin.doorprize') }}" target="_blank" class="border-transparent text-gray-500 hover:text-purple-600 hover:border-purple-300 border-b-4 py-4 px-1 font-bold text-lg transition flex items-center gap-2">
                    🎁 Undian Hadiah
                </a>
                <a href="{{ route('admin.duplicates') }}" class="border-amber-500 text-amber-600 border-b-4 py-4 px-1 font-black text-lg tracking-wide flex items-center gap-2">
                    ⚠️ Data Duplikat
                    @php $totalDupGroups = ($summary['ktp_groups'] ?? 0) + ($summary['wa_groups'] ?? 0); @endphp
                    @if($totalDupGroups > 0)
                        <span class="bg-amber-100 text-amber-800 text-xs font-extrabold px-2.5 py-0.5 rounded-full border border-amber-300">
                            {{ $summary['ktp_groups'] }} KTP
                        </span>
                    @endif
                </a>
                @if(auth()->user()->isSuperadmin())
                    <a href="{{ route('admin.users') }}" class="border-transparent text-gray-500 hover:text-purple-600 hover:border-purple-300 border-b-4 py-4 px-1 font-bold text-lg transition flex items-center gap-2">
                        👥 Manajemen Akun
                    </a>
                @endif
            </nav>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 shadow-sm rounded-r" role="alert">
            <p class="font-bold">Berhasil!</p>
            <p>{{ session('success') }}</p>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-8 shadow-sm rounded-r" role="alert">
            <p class="font-bold">Gagal!</p>
            <p>{{ session('error') }}</p>
        </div>
        @endif

        <!-- Filter Sub-Tabs Tipe Duplikat -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-100 pb-6 mb-6">
                <div>
                    <h1 class="text-2xl font-black text-gray-900 flex items-center gap-2">
                        <span>⚠️</span> Deteksi Data Pendaftaran Ganda
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Pilih kriteria deteksi untuk menemukan pendaftar yang mendaftar lebih dari satu kali.
                    </p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.duplicates', ['type' => 'ktp', 'search' => request('search'), 'status' => request('status')]) }}" 
                       class="px-5 py-2.5 rounded-xl font-bold text-sm transition flex items-center gap-2 {{ $type === 'ktp' ? 'bg-amber-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <span>🆔</span> Nomor KTP / NIK
                        <span class="px-2 py-0.5 rounded-full text-xs font-black {{ $type === 'ktp' ? 'bg-white text-amber-700' : 'bg-gray-200 text-gray-700' }}">
                            {{ $summary['ktp_groups'] }}
                        </span>
                    </a>

                    <a href="{{ route('admin.duplicates', ['type' => 'wa', 'search' => request('search'), 'status' => request('status')]) }}" 
                       class="px-5 py-2.5 rounded-xl font-bold text-sm transition flex items-center gap-2 {{ $type === 'wa' ? 'bg-amber-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <span>📞</span> No. WhatsApp
                        <span class="px-2 py-0.5 rounded-full text-xs font-black {{ $type === 'wa' ? 'bg-white text-amber-700' : 'bg-gray-200 text-gray-700' }}">
                            {{ $summary['wa_groups'] }}
                        </span>
                    </a>

                    <a href="{{ route('admin.duplicates', ['type' => 'name', 'search' => request('search'), 'status' => request('status')]) }}" 
                       class="px-5 py-2.5 rounded-xl font-bold text-sm transition flex items-center gap-2 {{ $type === 'name' ? 'bg-amber-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <span>👤</span> Nama Lengkap
                        <span class="px-2 py-0.5 rounded-full text-xs font-black {{ $type === 'name' ? 'bg-white text-amber-700' : 'bg-gray-200 text-gray-700' }}">
                            {{ $summary['name_groups'] }}
                        </span>
                    </a>
                </div>
            </div>

            <!-- Form Pencarian & Filter Status -->
            <form action="{{ route('admin.duplicates') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                <input type="hidden" name="type" value="{{ $type }}">

                <div class="flex-grow w-full md:w-auto">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">
                        Cari Kata Kunci ({{ $type === 'ktp' ? 'NIK KTP' : ($type === 'wa' ? 'No. WA' : 'Nama') }})
                    </label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci..." 
                           class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500 outline-none">
                </div>

                <div class="w-full md:w-56">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Filter Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-amber-500 outline-none bg-white">
                        <option value="">Semua Status</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Hanya Yang Lunas</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Hanya Yang Belum Lunas</option>
                    </select>
                </div>

                <div class="flex gap-2 w-full md:w-auto">
                    <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-6 rounded-lg transition shadow-sm">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('admin.duplicates', ['type' => $type]) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded-lg transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Daftar Grup Duplikat -->
        @if($groupedDuplicates->isNotEmpty())
            <div class="space-y-8">
                @foreach($groupedDuplicates as $keyValue => $items)
                    @php
                        $paidCount = $items->where('payment_status', 'paid')->count();
                        $pendingCount = $items->where('payment_status', 'pending')->count();
                    @endphp

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        
                        <!-- Header Grup Duplikat -->
                        <div class="p-4 sm:p-5 bg-gradient-to-r from-gray-900 to-gray-800 text-white flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                            <div class="flex items-center gap-3">
                                <span class="bg-amber-500 text-gray-900 font-black px-3 py-1 rounded-lg text-sm uppercase tracking-wider">
                                    {{ $type === 'ktp' ? 'KTP' : ($type === 'wa' ? 'WA' : 'NAMA') }}
                                </span>
                                <div>
                                    <h3 class="text-lg font-mono font-bold text-amber-300">
                                        {{ $keyValue }}
                                    </h3>
                                    <p class="text-xs text-gray-300">
                                        Nama Terdaftar: <span class="font-semibold text-white">{{ $items->pluck('full_name')->unique()->join(', ') }}</span>
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="bg-gray-800 text-gray-200 px-3 py-1 rounded-full text-xs font-bold border border-gray-700">
                                    Total: {{ $items->count() }} Data
                                </span>
                                @if($paidCount > 0)
                                    <span class="bg-green-600 text-white px-3 py-1 rounded-full text-xs font-black shadow">
                                        ✅ {{ $paidCount }} LUNAS
                                    </span>
                                @endif
                                @if($pendingCount > 0)
                                    <span class="bg-yellow-500 text-gray-900 px-3 py-1 rounded-full text-xs font-black shadow">
                                        ⏳ {{ $pendingCount }} PENDING
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Tabel Anggota Grup -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                                        <th class="p-4 font-semibold">ID & Kode Booking</th>
                                        <th class="p-4 font-semibold">Nama Peserta</th>
                                        <th class="p-4 font-semibold text-center">Kategori</th>
                                        <th class="p-4 font-semibold">Kontak & NIK</th>
                                        <th class="p-4 font-semibold text-center">Status Bayar</th>
                                        <th class="p-4 font-semibold text-center">Bukti Bayar</th>
                                        <th class="p-4 font-semibold text-center">BIB</th>
                                        <th class="p-4 font-semibold text-center">Waktu Daftar</th>
                                        <th class="p-4 font-semibold text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm divide-y divide-gray-100">
                                    @foreach($items as $reg)
                                    <tr class="{{ $reg->payment_status == 'paid' ? 'bg-green-50/40 hover:bg-green-50' : 'hover:bg-gray-50' }} transition">
                                        
                                        <td class="p-4 align-middle">
                                            <span class="text-xs text-gray-400 font-mono">#{{ $reg->id }}</span>
                                            <p class="font-mono font-bold text-blue-600">{{ $reg->registration_code }}</p>
                                        </td>

                                        <td class="p-4 align-middle">
                                            <p class="font-bold text-gray-900">{{ $reg->full_name }}</p>
                                            <p class="text-xs text-gray-500">Gender: {{ $reg->gender }} | Usia: {{ $reg->age }} th</p>
                                        </td>

                                        <td class="p-4 align-middle text-center">
                                            <span class="bg-gray-200 text-gray-800 py-1 px-2.5 rounded font-bold text-xs">
                                                {{ $reg->ticket_category }}
                                            </span>
                                            <p class="text-xs text-gray-500 mt-1">Jersey: {{ $reg->jersey_size ?: '-' }}</p>
                                        </td>

                                        <td class="p-4 align-middle text-xs text-gray-600">
                                            <p class="font-mono font-semibold">📞 {{ $reg->whatsapp }}</p>
                                            <p class="font-mono mt-0.5">🆔 {{ $reg->identity_number }}</p>
                                        </td>

                                        <td class="p-4 align-middle text-center">
                                            @if($reg->payment_status == 'paid')
                                                <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs font-black">
                                                    LUNAS
                                                </span>
                                            @elseif($reg->payment_proof)
                                                <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs font-bold animate-pulse">
                                                    Perlu Validasi
                                                </span>
                                            @else
                                                <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-xs font-semibold">
                                                    Belum Bayar
                                                </span>
                                            @endif
                                        </td>

                                        <td class="p-4 align-middle text-center">
                                            @if($reg->payment_proof)
                                                <button onclick="previewImage('{{ route('admin.receipt', $reg->id) }}')" type="button" 
                                                        class="bg-blue-50 hover:bg-blue-100 border border-blue-200 text-blue-700 font-bold py-1.5 px-3 rounded-lg text-xs transition inline-flex items-center shadow-sm">
                                                    👁️ Struk
                                                </button>
                                            @else
                                                <span class="text-gray-400 text-xs italic">-</span>
                                            @endif
                                        </td>

                                        <td class="p-4 align-middle text-center">
                                            @if($reg->bib_number)
                                                <span class="text-lg font-black text-blue-700">
                                                    {{ sprintf('%04d', $reg->bib_number) }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
                                        </td>

                                        <td class="p-4 align-middle text-center text-xs text-gray-500">
                                            {{ $reg->created_at ? $reg->created_at->format('d/m/Y H:i') : '-' }}
                                        </td>

                                        <td class="p-4 align-middle text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('admin.show', $reg->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg transition shadow-sm" title="Lihat Detail">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                </a>
                                                
                                                <form action="{{ route('admin.destroy', $reg->id) }}" method="POST" 
                                                      onsubmit="return confirm('PERINGATAN! Anda akan menghapus data pendaftaran [{{ $reg->registration_code }}] {{ $reg->full_name }} (Status: {{ strtoupper($reg->payment_status) }}). Tindakan ini permanen. Lanjutkan?');" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-lg transition shadow-sm" title="Hapus Data Duplikat">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center text-gray-500">
                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                    ✅
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-1">Tidak Ada Data Duplikat Ditemukan</h3>
                <p class="text-sm">Tidak ada data pendaftaran ganda berdasarkan kriteria filter yang Anda pilih.</p>
            </div>
        @endif

    </div>

    <!-- Modal Preview Gambar Bukti Bayar -->
    <div id="imageModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-80 backdrop-blur-sm flex items-center justify-center p-4 transition-all opacity-0">
        <div class="relative max-w-2xl w-full mx-auto flex flex-col items-center transform scale-95 transition-transform duration-300" id="modalContent">
            <button onclick="closePreview()" class="absolute -top-12 right-0 md:-right-12 text-white hover:text-red-500 bg-gray-800 hover:bg-white rounded-full p-2 transition focus:outline-none shadow-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <img id="previewImg" src="" alt="Bukti Pembayaran" class="w-full max-h-[85vh] object-contain rounded-xl shadow-2xl border-4 border-white bg-white">
            <p class="text-white text-sm mt-4 font-semibold tracking-wide">Tekan tombol silang atau area luar untuk menutup.</p>
        </div>
    </div>

    <script>
        function previewImage(url) {
            const modal = document.getElementById('imageModal');
            const img = document.getElementById('previewImg');
            const content = document.getElementById('modalContent');
            img.setAttribute('src', url);
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                content.classList.remove('scale-95');
                content.classList.add('scale-100');
            }, 10);
            document.body.classList.add('overflow-hidden');
        }

        function closePreview() {
            const modal = document.getElementById('imageModal');
            const content = document.getElementById('modalContent');
            const img = document.getElementById('previewImg');
            modal.classList.add('opacity-0');
            content.classList.remove('scale-100');
            content.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                img.src = '';
                document.body.classList.remove('overflow-hidden');
            }, 300);
        }

        document.getElementById('imageModal')?.addEventListener('click', function(e) {
            if (e.target === this) closePreview();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('imageModal').classList.contains('hidden')) {
                closePreview();
            }
        });
    </script>

</body>
</html>
