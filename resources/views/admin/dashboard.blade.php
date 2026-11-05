<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - MRP Run 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <a href="{{ route('admin.dashboard') }}" class="border-blue-500 text-blue-600 border-b-4 py-4 px-1 font-black text-lg tracking-wide">
                    📊 Dashboard & Pembayaran
                </a>
                <a href="{{ route('admin.racepack') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-4 py-4 px-1 font-bold text-lg transition">
                    🎒 Manajemen Racepack (Daftar Ulang)
                </a>
                <a href="{{ route('admin.doorprize') }}" target="_blank" class="border-transparent text-gray-500 hover:text-purple-600 hover:border-purple-300 border-b-4 py-4 px-1 font-bold text-lg transition flex items-center gap-2">
                    🎁 Undian Hadiah
                </a>
                <a href="{{ route('admin.duplicates') }}" class="border-transparent text-gray-500 hover:text-amber-600 hover:border-amber-300 border-b-4 py-4 px-1 font-bold text-lg transition flex items-center gap-2">
                    ⚠️ Data Duplikat
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

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-700 text-white rounded-2xl shadow-lg p-5 flex flex-col justify-center items-center text-center transform transition hover:-translate-y-1">
                <span class="text-blue-100 text-xs font-semibold uppercase mb-1">Total Pendaftar</span>
                <span class="text-3xl font-black">{{ $stats['total'] }}</span>
            </div>
            <div class="bg-gradient-to-br from-emerald-400 to-emerald-600 text-white rounded-2xl shadow-lg p-5 flex flex-col justify-center items-center text-center transform transition hover:-translate-y-1">
                <span class="text-emerald-100 text-xs font-semibold uppercase mb-1">Kategori 5K</span>
                <span class="text-3xl font-black">{{ $stats['5k'] }}</span>
            </div>
            <div class="bg-gradient-to-br from-purple-500 to-purple-700 text-white rounded-2xl shadow-lg p-5 flex flex-col justify-center items-center text-center transform transition hover:-translate-y-1">
                <span class="text-purple-100 text-xs font-semibold uppercase mb-1">Kategori 10K</span>
                <span class="text-3xl font-black">{{ $stats['10k'] }}</span>
            </div>
            <div class="bg-gradient-to-br from-teal-500 to-teal-700 text-white rounded-2xl shadow-lg p-5 flex flex-col justify-center items-center text-center transform transition hover:-translate-y-1">
                <span class="text-teal-100 text-xs font-semibold uppercase mb-1">Finisher Package</span>
                <span class="text-3xl font-black">{{ $stats['finisher'] ?? 0 }}</span>
            </div>
            <div class="bg-gradient-to-br from-amber-400 to-orange-500 text-white rounded-2xl shadow-lg p-5 flex flex-col justify-center items-center text-center transform transition hover:-translate-y-1 sm:col-span-2 md:col-span-1">
                <span class="text-orange-50 text-xs font-semibold uppercase mb-1">Menunggu Validasi</span>
                <span class="text-3xl font-black">{{ $stats['pending'] }}</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <h2 class="text-lg font-bold text-gray-800 text-center mb-6">Perbandingan Kategori Tiket</h2>
            <div class="relative h-64 w-full flex justify-center">
                <canvas id="kategoriChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
            <form action="{{ route('admin.dashboard') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-grow w-full md:w-auto">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Cari Nama / Kode / WA</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci..." class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
                </div>
                <div class="w-full md:w-56">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Kategori</label>
                    <select name="category" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                        <option value="">Semua Kategori</option>
                        <option value="5K" {{ request('category') == '5K' ? 'selected' : '' }}>5K Regular</option>
                        <option value="10K" {{ request('category') == '10K' ? 'selected' : '' }}>10K Regular</option>
                        <option value="FINISHER" {{ request('category') == 'FINISHER' ? 'selected' : '' }}>Semua Finisher Package</option>
                        <option value="Finisher Package 5K" {{ request('category') == 'Finisher Package 5K' ? 'selected' : '' }}>Finisher Package 5K</option>
                        <option value="Finisher Package 10K" {{ request('category') == 'Finisher Package 10K' ? 'selected' : '' }}>Finisher Package 10K</option>
                    </select>
                </div>
                <div class="w-full md:w-48">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                        <option value="">Semua Status</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                        <option value="pending_proof" {{ request('status') == 'pending_proof' ? 'selected' : '' }}>Perlu Validasi</option>
                        <option value="pending_no_proof" {{ request('status') == 'pending_no_proof' ? 'selected' : '' }}>Belum Bayar</option>
                    </select>
                </div>
                <div class="flex gap-2 w-full md:w-auto">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">Filter</button>
                    @if(request()->hasAny(['search', 'category', 'status']))
                        <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded-lg transition">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center bg-gray-50 gap-4">
                <div class="flex items-center gap-3">
                    <h2 class="text-lg font-bold text-gray-800">Daftar Registrasi Peserta</h2>
                    <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs font-bold">
                        Total: {{ method_exists($registrations, 'total') ? $registrations->total() : $registrations->count() }}
                    </span>
                </div>
                
                <a href="{{ route('admin.export') }}" class="bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-bold py-2.5 px-5 rounded-lg shadow-md flex items-center transition">
                    <span class="mr-2">⬇️</span> Download Excel (.xlsx)
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                            <th class="p-4 font-semibold">Kode & Nama</th>
                            <th class="p-4 font-semibold text-center">Kategori</th>
                            <th class="p-4 font-semibold">Kontak</th>
                            <th class="p-4 font-semibold text-center">Status</th>
                            <th class="p-4 font-semibold text-center">Bukti Bayar</th>
                            
                            <th class="p-4 font-semibold text-center">Validasi</th>
                            <th class="p-4 font-semibold text-center">Aksi Data</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100">
                        @forelse($registrations as $reg)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 align-middle">
                                <p class="font-mono font-bold text-blue-600">{{ $reg->registration_code }}</p>
                                <p class="font-bold text-gray-900">{{ $reg->full_name }}</p>
                            </td>
                            <td class="p-4 align-middle text-center">
                                <span class="bg-gray-200 text-gray-700 py-1 px-2 rounded font-bold text-xs">{{ $reg->ticket_category }}</span>
                                <p class="text-xs text-gray-500 mt-1">Jersey: {{ $reg->jersey_size }}</p>
                            </td>
                            <td class="p-4 text-gray-600 align-middle">
                                <p class="flex items-center gap-1"><span class="text-lg">📞</span> {{ $reg->whatsapp }}</p>
                            </td>
                            <td class="p-4 align-middle text-center">
                                @if($reg->payment_status == 'pending' && $reg->payment_proof == null)
                                    <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full text-xs font-semibold">Belum Bayar</span>
                                @elseif($reg->payment_status == 'pending' && $reg->payment_proof != null)
                                    <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs font-semibold animate-pulse">Perlu Validasi</span>
                                @else
                                    <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs font-semibold">LUNAS</span>
                                @endif
                            </td>
                            
                            <td class="p-4 align-middle text-center">
                                @if($reg->payment_proof)
                                    <button onclick="previewImage('{{ route('admin.receipt', $reg->id) }}')" type="button" class="bg-blue-50 hover:bg-blue-100 border border-blue-200 text-blue-700 font-bold py-1.5 px-3 rounded-lg text-xs transition inline-flex items-center justify-center shadow-sm w-full max-w-[110px]">
                                        👁️ Lihat Struk
                                    </button>
                                @else
                                    <span class="text-gray-400 text-xs italic">-</span>
                                @endif
                            </td>

                            <td class="p-4 align-middle text-center">
                                @if($reg->payment_status == 'pending' && $reg->payment_proof != null)
                                    <form action="{{ route('admin.verify', $reg->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin dana sudah masuk ke rekening dan ingin memvalidasi tiket ini?');">
                                        @csrf
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1.5 px-3 rounded-lg text-xs shadow transition w-full max-w-[110px]">
                                            ✅ Validasi
                                        </button>
                                    </form>
                                @elseif($reg->payment_status == 'paid')
                                    <div class="flex flex-col items-center gap-1">
                                        <span class="text-green-600 font-bold text-xs flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Terverifikasi
                                        </span>
                                        <form action="{{ route('admin.cancel_verify', $reg->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan validasi? Status tiket akan kembali menjadi Perlu Validasi.');">
                                            @csrf
                                            <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 font-bold py-1 px-3 rounded-lg text-xs transition w-full max-w-[110px]">
                                                ❌ Batal Lunas
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>

                            <td class="p-4 align-middle text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.show', $reg->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg transition shadow-sm" title="Lihat Data Lengkap">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    
                                    <form action="{{ route('admin.destroy', $reg->id) }}" method="POST" onsubmit="return confirm('PERINGATAN! Data peserta {{ $reg->full_name }} akan dihapus permanen. Aksi ini tidak dapat dibatalkan. Lanjutkan?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-lg transition shadow-sm" title="Hapus Data">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-500">
                                <p class="text-lg font-bold mb-1">Data tidak ditemukan</p>
                                <p class="text-sm">Tidak ada pendaftar yang cocok dengan filter Anda.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($registrations->hasPages())
                <div class="p-6 border-t border-gray-100 bg-gray-50 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <p class="text-sm text-gray-500 font-medium">
                        Menampilkan <span class="font-bold text-gray-800">{{ $registrations->firstItem() ?? 0 }}</span> - <span class="font-bold text-gray-800">{{ $registrations->lastItem() ?? 0 }}</span> dari <span class="font-bold text-gray-800">{{ $registrations->total() }}</span> total pendaftar
                    </p>
                    <div class="overflow-x-auto">
                        {{ $registrations->links() }}
                    </div>
                </div>
            @endif
        </div>

    </div>

    <!-- Modal Preview Gambar Bukti Bayar -->
    <div id="imageModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-80 backdrop-blur-sm flex items-center justify-center p-4 transition-all opacity-0">
        <div class="relative max-w-2xl w-full mx-auto flex flex-col items-center transform scale-95 transition-transform duration-300" id="modalContent">
            
            <button onclick="closePreview()" class="absolute -top-12 right-0 md:-right-12 text-white hover:text-red-500 bg-gray-800 hover:bg-white rounded-full p-2 transition focus:outline-none shadow-lg" title="Tutup">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            
            <img id="previewImg" src="" alt="Bukti Pembayaran" class="w-full max-h-[80vh] object-contain rounded-xl shadow-2xl border-4 border-white bg-white">
            
            <div class="flex items-center justify-between w-full mt-3 px-2">
                <a id="previewDirectLink" href="#" target="_blank" class="text-xs text-blue-300 hover:text-white font-bold underline flex items-center gap-1">
                    <span>↗</span> Buka Gambar di Tab Baru
                </a>
                <p class="text-gray-300 text-xs font-semibold">Tekan tombol silang atau ESC untuk menutup.</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const chartCanvas = document.getElementById('kategoriChart');
            if (chartCanvas) {
                const ctx = chartCanvas.getContext('2d');
                const data5K = {{ $stats['5k'] ?? 0 }};
                const data10K = {{ $stats['10k'] ?? 0 }};
                const dataFinisher = {{ $stats['finisher'] ?? 0 }};

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Kategori 5K', 'Kategori 10K', 'Finisher Package'],
                        datasets: [{
                            data: [data5K, data10K, dataFinisher],
                            backgroundColor: ['#34d399', '#a855f7', '#0d9488'],
                            hoverBackgroundColor: ['#059669', '#7e22ce', '#0f766e'],
                            borderWidth: 0,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { position: 'bottom', labels: { font: { family: "'Nunito', 'sans-serif'", size: 14 } } }
                        },
                        cutout: '70%'
                    }
                });
            }

            // Pasang event listener modal setelah DOM siap
            const modal = document.getElementById('imageModal');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closePreview();
                    }
                });
            }
        });

        // Fungsi untuk membuka pop-up gambar
        function previewImage(url) {
            const modal = document.getElementById('imageModal');
            const img = document.getElementById('previewImg');
            const content = document.getElementById('modalContent');
            const directLink = document.getElementById('previewDirectLink');
            
            if (img) img.setAttribute('src', url);
            if (directLink) directLink.setAttribute('href', url);
            
            if (modal && content) {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    content.classList.remove('scale-95');
                    content.classList.add('scale-100');
                }, 10);
            }
            
            document.body.classList.add('overflow-hidden');
        }

        // Fungsi untuk menutup pop-up
        function closePreview() {
            const modal = document.getElementById('imageModal');
            const content = document.getElementById('modalContent');
            const img = document.getElementById('previewImg');
            
            if (modal && content) {
                modal.classList.add('opacity-0');
                content.classList.remove('scale-100');
                content.classList.add('scale-95');
                
                setTimeout(() => {
                    modal.classList.add('hidden');
                    if (img) img.src = '';
                    document.body.classList.remove('overflow-hidden');
                }, 300);
            }
        }

        // Tutup modal menggunakan tombol ESC di keyboard
        document.addEventListener('keydown', function(e) {
            const modal = document.getElementById('imageModal');
            if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                closePreview();
            }
        });
    </script>
    
</body>
</html>