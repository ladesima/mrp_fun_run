<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Racepack - Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>
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

                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-sm font-bold transition">
                        Logout
                    </button>
                </form>

            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="mb-8 border-b-2 border-gray-200">
            <nav class="flex space-x-8">

                @if(auth()->user()->isSuperadmin())
                    <a href="{{ route('admin.dashboard') }}"
                        class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 border-b-4 py-4 px-1 font-bold text-lg transition">
                        📊 Dashboard & Pembayaran
                    </a>
                @endif

                <a href="{{ route('admin.racepack') }}"
                    class="border-blue-500 text-blue-600 border-b-4 py-4 px-1 font-black text-lg tracking-wide">
                    🎒 Manajemen Racepack
                </a>

                @if(auth()->user()->isSuperadmin())
                    <a href="{{ route('admin.doorprize') }}"
                        target="_blank"
                        class="border-transparent text-gray-500 hover:text-purple-600 hover:border-purple-300 border-b-4 py-4 px-1 font-bold text-lg transition flex items-center gap-2">
                        🎁 Undian Hadiah
                    </a>

                    <a href="{{ route('admin.duplicates') }}"
                        class="border-transparent text-gray-500 hover:text-amber-600 hover:border-amber-300 border-b-4 py-4 px-1 font-bold text-lg transition flex items-center gap-2">
                        ⚠️ Data Duplikat
                    </a>

                    <a href="{{ route('admin.users') }}"
                        class="border-transparent text-gray-500 hover:text-purple-600 hover:border-purple-300 border-b-4 py-4 px-1 font-bold text-lg transition flex items-center gap-2">
                        👥 Manajemen Akun
                    </a>
                @endif

            </nav>
        </div>

        <!-- Ringkasan Statistik Racepack & Kinerja Petugas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Peserta Lunas</p>
                    <p class="text-3xl font-black text-gray-900 mt-1">{{ number_format($totalPaid ?? $registrations->total()) }}</p>
                    <p class="text-[11px] text-gray-400 mt-0.5">Peserta berhak mengambil racepack</p>
                </div>
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-2xl">
                    👥
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-emerald-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Sudah Daftar Ulang</p>
                    <p class="text-3xl font-black text-emerald-600 mt-1">{{ number_format($totalCollected ?? 0) }}</p>
                    <p class="text-[11px] text-gray-400 mt-0.5">
                        @if(($totalPaid ?? 0) > 0)
                            {{ round((($totalCollected ?? 0) / $totalPaid) * 100, 1) }}% dari total peserta
                        @else
                            0%
                        @endif
                    </p>
                </div>
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-2xl">
                    ✅
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-amber-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-amber-600 uppercase tracking-wider">Belum Daftar Ulang</p>
                    <p class="text-3xl font-black text-amber-600 mt-1">{{ number_format($totalUncollected ?? 0) }}</p>
                    <p class="text-[11px] text-gray-400 mt-0.5">Menunggu pengambilan racepack</p>
                </div>
                <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-2xl">
                    ⏳
                </div>
            </div>
        </div>

        <!-- Rekap Kinerja / Jumlah Verifikasi per Admin -->
        @if(isset($adminStats) && $adminStats->count() > 0)
        <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-sm mb-6">
            <div class="flex items-center gap-2 mb-3">
                <span class="text-lg">📊</span>
                <h3 class="font-bold text-gray-800 text-sm uppercase tracking-wider">Rekap Jumlah Verifikasi per Petugas Admin</h3>
            </div>
            <div class="flex flex-wrap gap-3">
                @foreach($adminStats as $stat)
                    <div class="bg-gray-50 hover:bg-blue-50 border border-gray-200 hover:border-blue-300 rounded-xl p-3 flex items-center gap-3 transition">
                        <div class="w-9 h-9 rounded-lg bg-blue-600 text-white font-bold flex items-center justify-center text-sm shadow-sm">
                            👤
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-800">
                                {{ $stat->racepackCollector ? $stat->racepackCollector->name : 'Admin #' . $stat->racepack_collected_by }}
                            </p>
                            <p class="text-xs text-blue-700 font-black">
                                {{ number_format($stat->count) }} Peserta Diverifikasi
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="bg-gray-900 rounded-2xl p-6 mb-6 shadow-lg">

            <div class="flex items-center justify-between mb-4">
                <h2 class="text-white text-xl font-black">
                    📷 SCAN QR CODE PESERTA
                </h2>

                <div class="flex gap-2">
                    <button id="switchCamera" class="hidden bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 px-4 rounded-xl transition" title="Ganti Kamera (Depan/Belakang)">
                        🔄
                    </button>
                    <button id="startScanner" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition">
                        ▶ Mulai Scan
                    </button>
                </div>
            </div>

            <p class="text-gray-300 mb-4">
                Klik tombol scan lalu arahkan kamera ke QR Code tiket peserta.
            </p>

            <div id="reader"
                class="hidden w-full max-w-xl mx-auto overflow-hidden rounded-xl border-4 border-white">
            </div>

        </div>

        <form id="scanForm" action="{{ route('admin.racepack.scan') }}" method="POST" class="hidden">
            @csrf
            <input type="text" name="qr_code" id="qr_result">
        </form>

        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r shadow">
            <p class="font-bold">Berhasil!</p>
            <p>{{ session('success') }}</p>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r shadow">
            <p class="font-bold">Gagal!</p>
            <p>{{ session('error') }}</p>
        </div>
        @endif

        <!-- Rekapitulasi Ukuran Jersey -->
        @if(isset($jerseyStats) && $jerseyStats->count() > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2 mb-3">
                <h3 class="text-sm font-black text-gray-800 uppercase tracking-wider flex items-center gap-2">
                    <span>👕</span> Rekap Pengambilan Ukuran Baju / Jersey
                </h3>
                <span class="text-xs text-gray-500 font-medium">Klik ukuran untuk filter data tabel</span>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
                @foreach($jerseyStats as $js)
                    @php
                        $sizeLabel = $js->jersey_size ?: '-';
                        $isActive = request('jersey_size') === $js->jersey_size;
                        $percent = $js->total > 0 ? round(($js->collected_count / $js->total) * 100) : 0;
                    @endphp
                    <a href="{{ route('admin.racepack', array_merge(request()->query(), ['jersey_size' => $isActive ? '' : $js->jersey_size])) }}"
                       class="p-3 rounded-xl border transition flex flex-col justify-between {{ $isActive ? 'bg-blue-600 text-white border-blue-700 shadow-md ring-2 ring-blue-300' : 'bg-gray-50 hover:bg-blue-50 border-gray-200 text-gray-800' }}">
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-black text-sm {{ $isActive ? 'text-white' : 'text-blue-900' }}">
                                {{ $sizeLabel === '-' ? 'Finisher / Tanpa Jersey' : 'Size ' . $sizeLabel }}
                            </span>
                            <span class="text-[11px] font-bold px-1.5 py-0.5 rounded {{ $isActive ? 'bg-blue-800 text-white' : 'bg-blue-100 text-blue-800' }}">
                                {{ $percent }}%
                            </span>
                        </div>
                        <div class="text-xs {{ $isActive ? 'text-blue-100' : 'text-gray-600' }} mt-1">
                            <div>Diambil: <strong class="{{ $isActive ? 'text-white' : 'text-green-700' }}">{{ $js->collected_count }}</strong> / {{ $js->total }}</div>
                            <div class="text-[11px] mt-0.5">Sisa: <strong>{{ max(0, $js->total - $js->collected_count) }}</strong></div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Filter & Pencarian Peserta -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-6">

            <form action="{{ route('admin.racepack') }}"
                method="GET"
                class="flex flex-col md:flex-row gap-3 flex-wrap">

                <div class="flex-grow min-w-[240px]">
                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari Nomor BIB, Nama, NIK, Alamat, Booking..."
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-sm font-bold">
                </div>

                <!-- Filter Status -->
                <div class="w-full md:w-40">
                    <select name="status" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-xs font-bold bg-white">
                        <option value="">-- Semua Status --</option>
                        <option value="collected" {{ request('status') === 'collected' ? 'selected' : '' }}>✅ Sudah Ambil</option>
                        <option value="uncollected" {{ request('status') === 'uncollected' ? 'selected' : '' }}>❌ Belum Ambil</option>
                    </select>
                </div>

                <!-- Filter Ukuran Jersey -->
                @if(isset($allJerseySizes) && $allJerseySizes->count() > 0)
                <div class="w-full md:w-40">
                    <select name="jersey_size" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-xs font-bold bg-white">
                        <option value="">-- Semua Ukuran --</option>
                        @foreach($allJerseySizes as $size)
                            <option value="{{ $size }}" {{ request('jersey_size') === $size ? 'selected' : '' }}>
                                👕 {{ $size === '-' ? '- (Tanpa Jersey)' : 'Ukuran ' . $size }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <!-- Filter Urutkan -->
                <div class="w-full md:w-48">
                    <select name="sort_by" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-xs font-bold bg-white">
                        <option value="default" {{ request('sort_by') === 'default' || !request('sort_by') ? 'selected' : '' }}>⚡ Urut: Validasi Terbaru</option>
                        <option value="jersey_asc" {{ request('sort_by') === 'jersey_asc' ? 'selected' : '' }}>👕 Urut: Ukuran Jersey (A-Z)</option>
                        <option value="jersey_desc" {{ request('sort_by') === 'jersey_desc' ? 'selected' : '' }}>👕 Urut: Ukuran Jersey (Z-A)</option>
                        <option value="bib_asc" {{ request('sort_by') === 'bib_asc' ? 'selected' : '' }}>🔢 Urut: Nomor BIB (Terkecil)</option>
                    </select>
                </div>

                <!-- Filter Petugas -->
                @if(isset($allAdmins) && $allAdmins->count() > 0)
                <div class="w-full md:w-44">
                    <select name="collector_id" class="w-full px-3 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none text-xs font-bold bg-white">
                        <option value="">-- Semua Petugas --</option>
                        @foreach($allAdmins as $adm)
                            <option value="{{ $adm->id }}" {{ (string)($selectedCollector ?? request('collector_id')) === (string)$adm->id ? 'selected' : '' }}>
                                👤 {{ $adm->name }} {{ $adm->id === auth()->id() ? '(Saya)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div class="flex gap-2">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-lg text-sm transition">
                        CARI
                    </button>
                    @if(request()->hasAny(['search', 'status', 'jersey_size', 'sort_by', 'collector_id']))
                        <a href="{{ route('admin.racepack', ['collector_id' => '']) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2.5 px-4 rounded-lg text-sm transition flex items-center" title="Tampilkan Semua Data">
                            Semua Data
                        </a>
                    @endif
                </div>

            </form>

        </div>

        <!-- Tabel Peserta Racepack -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">

            <div class="p-6 border-b border-gray-100 bg-gray-50 flex flex-col sm:flex-row justify-between items-center gap-4">

                <div class="flex items-center gap-3 flex-wrap">
                    <h2 class="text-lg font-bold text-gray-800">
                        Daftar Peserta Terverifikasi
                    </h2>
                    <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs font-bold">
                        Total: {{ method_exists($registrations, 'total') ? $registrations->total() : $registrations->count() }}
                    </span>
                    @if(request('jersey_size'))
                        <span class="bg-indigo-100 text-indigo-800 border border-indigo-200 py-1 px-2.5 rounded-full text-xs font-black">
                            👕 Filter: Ukuran {{ request('jersey_size') }}
                        </span>
                    @endif
                </div>

                <a href="{{ route('admin.export.racepack', request()->query()) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-5 rounded-xl shadow-sm transition flex items-center text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download Rekap Excel (Sesuai Filter)
                </a>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-left border-collapse">

                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-sm uppercase tracking-wider border-b border-gray-200">

                            <th class="p-4 text-center">BIB</th>
                            <th class="p-4">Peserta</th>
                            <th class="p-4 text-center">Jersey</th>
                            <th class="p-4 text-center">Status & Petugas Verifikasi</th>
                            <th class="p-4 text-center">Aksi</th>

                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse($registrations as $reg)

                        <tr class="{{ $reg->is_racepack_collected ? 'bg-green-50/50' : 'bg-white' }}">

                            <td class="p-4 text-center">
                                <span class="text-3xl font-black text-blue-700">
                                    {{ sprintf('%04d', $reg->bib_number) }}
                                </span>
                            </td>

                            <td class="p-4">
                                <p class="font-bold uppercase text-lg text-gray-900">
                                    {{ $reg->full_name }}
                                </p>

                                <div class="text-xs text-gray-600 mt-1 flex items-center gap-2 flex-wrap">
                                    <span class="font-semibold text-blue-700 bg-blue-50 px-2 py-0.5 rounded border border-blue-200">{{ $reg->ticket_category }}</span>
                                    <span class="font-mono text-gray-800 bg-gray-100 px-2 py-0.5 rounded border border-gray-300 font-semibold">🆔 NIK: {{ $reg->identity_number ?: '-' }}</span>
                                    @if($reg->address)
                                        <span class="text-gray-600 bg-gray-50 px-2 py-0.5 rounded border border-gray-200 text-[11px] truncate max-w-xs" title="{{ $reg->address }}">📍 {{ $reg->address }}</span>
                                    @endif
                                </div>
                            </td>

                            <td class="p-4 text-center">
                                <span class="bg-gray-800 text-white px-4 py-2 rounded-lg font-black">
                                    {{ $reg->jersey_size ?: '-' }}
                                </span>
                            </td>

                            <td class="p-4 text-center">

                                @if($reg->is_racepack_collected)

                                    <div class="inline-flex flex-col items-center">
                                        <span class="bg-green-100 text-green-800 border border-green-300 py-1.5 px-3.5 rounded-full font-black text-xs shadow-sm">
                                            ✅ SUDAH DAFTAR ULANG
                                        </span>
                                        @if($reg->racepackCollector || $reg->racepack_collected_by || $reg->racepack_collected_at)
                                            <div class="text-[11px] text-gray-600 mt-1.5 flex flex-col items-center">
                                                <span class="font-bold text-gray-800">👤 {{ $reg->racepackCollector ? $reg->racepackCollector->name : ($reg->racepack_collected_by ? (\App\Models\User::find($reg->racepack_collected_by)?->name ?? 'Admin') : 'Admin') }}</span>
                                                @if($reg->racepack_collected_at)
                                                    <span class="text-gray-500 font-mono text-[10px]">🕒 {{ \Carbon\Carbon::parse($reg->racepack_collected_at)->timezone('Asia/Makassar')->format('d/m/Y H:i') }} WITA</span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                @else

                                    <span class="bg-red-100 text-red-600 border border-red-200 py-1.5 px-3.5 rounded-full font-bold text-xs">
                                        ❌ BELUM DAFTAR ULANG
                                    </span>

                                @endif

                            </td>
                            <td class="p-4 text-center">

                                <div class="flex items-center justify-center gap-2">

                                    @if(!$reg->is_racepack_collected)

                                        <form action="{{ route('admin.racepack.manual', $reg->id) }}"
                                            method="POST">

                                            @csrf

                                            <button type="submit"
                                                onclick="return confirm('Validasi manual peserta ini?')"
                                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded-lg transition text-xs shadow-sm">
                                                ✅ Validasi
                                            </button>

                                        </form>

                                    @else

                                        <a href="{{ route('admin.racepack.backdrop', $reg->id) }}"
                                            target="_blank"
                                            class="bg-purple-600 hover:bg-purple-700 text-white font-bold px-4 py-2 rounded-lg transition text-xs shadow-sm">
                                            🎨 Backdrop
                                        </a>

                                    @endif

                                </div>

                            </td>
                        </tr>

                        @empty

                        <tr>
                            <td colspan="5" class="p-8 text-center text-gray-500">
                                Tidak ada data peserta yang sesuai filter.
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            @if($registrations->hasPages())
                <div class="p-6 border-t border-gray-100 bg-gray-50 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <p class="text-sm text-gray-500 font-medium">
                        Menampilkan <span class="font-bold text-gray-800">{{ $registrations->firstItem() ?? 0 }}</span> - <span class="font-bold text-gray-800">{{ $registrations->lastItem() ?? 0 }}</span> dari <span class="font-bold text-gray-800">{{ $registrations->total() }}</span> peserta
                    </p>
                    <div class="overflow-x-auto">
                        {{ $registrations->links() }}
                    </div>
                </div>
            @endif

        </div>

        <!-- ========================================== -->
        <!-- TABEL RIWAYAT / LOG AKTIVITAS VERIFIKASI TERKINI -->
        <!-- ========================================== -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-100 bg-gradient-to-r from-gray-900 to-gray-800 text-white flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-xl shadow">
                        🕒
                    </div>
                    <div>
                        <h2 class="text-lg font-black tracking-wide">Tabel Riwayat Aktivitas Verifikasi Terkini</h2>
                        <p class="text-xs text-gray-300">Menampilkan 20 aktivitas verifikasi pengambilan racepack terbaru secara real-time</p>
                    </div>
                </div>
                <span class="bg-blue-500/30 text-blue-200 border border-blue-400/40 text-xs px-3 py-1 rounded-full font-bold">
                    Live Activity Log
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 text-xs uppercase tracking-wider border-b border-gray-200">
                            <th class="p-4 font-bold text-center">Waktu Verifikasi</th>
                            <th class="p-4 font-bold">Petugas Verifikasi</th>
                            <th class="p-4 font-bold text-center">Nomor BIB</th>
                            <th class="p-4 font-bold">Nama Peserta & Kategori</th>
                            <th class="p-4 font-bold text-center">Ukuran Jersey</th>
                            <th class="p-4 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100">
                        @if(isset($recentActivities) && $recentActivities->count() > 0)
                            @foreach($recentActivities as $act)
                            <tr class="hover:bg-blue-50/40 transition">
                                <td class="p-4 text-center text-xs font-mono text-gray-600 whitespace-nowrap">
                                    <span class="bg-gray-100 border border-gray-200 px-2.5 py-1 rounded-lg">
                                        {{ \Carbon\Carbon::parse($act->racepack_collected_at)->timezone('Asia/Makassar')->format('d/m/Y H:i:s') }} WITA
                                    </span>
                                </td>

                                <td class="p-4">
                                    <div class="flex items-center gap-2">
                                        <span class="w-7 h-7 rounded-full bg-blue-100 text-blue-800 font-black text-xs flex items-center justify-center">
                                            👤
                                        </span>
                                        <div>
                                            <p class="font-bold text-gray-900 text-sm">
                                                {{ $act->racepackCollector ? $act->racepackCollector->name : ($act->racepack_collected_by ? (\App\Models\User::find($act->racepack_collected_by)?->name ?? 'Admin') : 'Admin') }}
                                            </p>
                                            <p class="text-[10px] text-gray-500">
                                                {{ ($act->racepackCollector && $act->racepackCollector->isSuperadmin()) || (\App\Models\User::find($act->racepack_collected_by)?->isSuperadmin()) ? '👑 Superadmin' : '🎒 Petugas Racepack' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="p-4 text-center">
                                    <span class="text-xl font-black text-blue-700 bg-blue-50 px-3 py-1 rounded-lg border border-blue-200">
                                        {{ sprintf('%04d', $act->bib_number) }}
                                    </span>
                                </td>

                                <td class="p-4">
                                    <p class="font-bold text-gray-900 uppercase">{{ $act->full_name }}</p>
                                    <p class="text-xs text-gray-500 font-mono">NIK: {{ $act->identity_number ?: '-' }} • <span class="font-semibold text-blue-600">{{ $act->ticket_category }}</span></p>
                                </td>

                                <td class="p-4 text-center">
                                    <span class="bg-gray-800 text-white text-xs px-2.5 py-1 rounded-md font-bold">
                                        {{ $act->jersey_size ?: '-' }}
                                    </span>
                                </td>

                                <td class="p-4 text-center">
                                    <a href="{{ route('admin.racepack.backdrop', $act->id) }}"
                                        target="_blank"
                                        class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-bold px-3 py-1.5 rounded-lg transition text-xs shadow-sm">
                                        🎨 Backdrop
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="p-8 text-center text-gray-400">
                                    Belum ada riwayat aktivitas verifikasi racepack yang tercatat.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        let html5QrCode;
        let scannerRunning = false;
        
        // Atur default ke kamera belakang (environment)
        let currentFacingMode = "environment"; 

        const startBtn = document.getElementById('startScanner');
        const switchBtn = document.getElementById('switchCamera');
        const readerDiv = document.getElementById('reader');

        startBtn.addEventListener('click', async function () {
            if (scannerRunning) return;

            // Membuka UI Scanner
            readerDiv.classList.remove('hidden');
            startBtn.classList.add('hidden');
            switchBtn.classList.remove('hidden');

            html5QrCode = new Html5Qrcode("reader");
            await startScanning();
        });

        // Event Listener untuk Tombol Ganti Kamera
        switchBtn.addEventListener('click', async function () {
            if (!scannerRunning) return;
            
            // Hentikan kamera yang sedang menyala
            await html5QrCode.stop();
            
            // Balikkan mode kamera (depan <-> belakang)
            currentFacingMode = currentFacingMode === "environment" ? "user" : "environment";
            
            // Mulai ulang dengan kamera baru
            await startScanning();
        });

        // Fungsi Inti untuk Menyalakan Kamera
        async function startScanning() {
            try {
                await html5QrCode.start(
                    { facingMode: currentFacingMode }, // Kunci utamanya ada di sini
                    {
                        fps: 10,
                        qrbox: { width: 250, height: 250 }
                    },
                    (decodedText) => {
                        // Jika berhasil discan
                        scannerRunning = false;
                        document.getElementById('qr_result').value = decodedText;
                        
                        html5QrCode.stop().then(() => {
                            document.getElementById('scanForm').submit();
                        });
                    }
                );
                scannerRunning = true;
            } catch (err) {
                console.error(err);
                alert("Kamera gagal dibuka!\nPastikan Anda telah memberikan izin akses kamera pada browser Anda.");
                
                // Kembalikan UI jika gagal
                readerDiv.classList.add('hidden');
                startBtn.classList.remove('hidden');
                switchBtn.classList.add('hidden');
                scannerRunning = false;
            }
        }
    </script>

</body>
</html>