<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Akun Admin - MRP Run Admin</title>
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
        
        <!-- Navigation Tabs -->
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
                <a href="{{ route('admin.duplicates') }}" class="border-transparent text-gray-500 hover:text-amber-600 hover:border-amber-300 border-b-4 py-4 px-1 font-bold text-lg transition">
                    ⚠️ Data Duplikat
                </a>
                <a href="{{ route('admin.users') }}" class="border-purple-600 text-purple-600 border-b-4 py-4 px-1 font-black text-lg tracking-wide flex items-center gap-2">
                    👥 Manajemen Akun
                </a>
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

        @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-8 shadow-sm rounded-r">
            <p class="font-bold mb-1">Periksa kembali data input:</p>
            <ul class="list-disc pl-5 text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Penjelasan Role -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-5 shadow-sm flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-600 text-white flex items-center justify-center text-2xl flex-shrink-0 shadow">
                    👑
                </div>
                <div>
                    <h3 class="font-bold text-blue-900 text-base mb-1">Superadmin</h3>
                    <p class="text-xs text-blue-700 leading-relaxed">
                        Akses penuh ke seluruh fitur: Dashboard & Validasi Pembayaran, Hapus Peserta, Deteksi Duplikat, Racepack, Ekspor Excel, Kelola Akun, & Undian.
                    </p>
                </div>
            </div>

            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-200 rounded-2xl p-5 shadow-sm flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-2xl flex-shrink-0 shadow">
                    🎒
                </div>
                <div>
                    <h3 class="font-bold text-emerald-900 text-base mb-1">Petugas Racepack</h3>
                    <p class="text-xs text-emerald-700 leading-relaxed">
                        Khusus petugas di lapangan: Scan QR Code tiket, verifikasi pengambilan Racepack (daftar ulang), backdrop nomor BIB, dan ekspor data racepack.
                    </p>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-50 to-fuchsia-50 border border-purple-200 rounded-2xl p-5 shadow-sm flex items-start gap-4">
                <div class="w-12 h-12 rounded-xl bg-purple-600 text-white flex items-center justify-center text-2xl flex-shrink-0 shadow">
                    🎁
                </div>
                <div>
                    <h3 class="font-bold text-purple-900 text-base mb-1">Petugas Doorprize</h3>
                    <p class="text-xs text-purple-700 leading-relaxed">
                        Khusus operator panggung: Mengakses Panel Pengundian Doorprize, membuka Layar Panggung Proyektor, mengontrol Spin & Stop, dan rekap pemenang.
                    </p>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar Akun -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gray-50 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div>
                    <h2 class="text-lg font-black text-gray-900">Daftar Akun Admin</h2>
                    <p class="text-xs text-gray-500 mt-0.5">Total: <span class="font-bold text-gray-800">{{ $users->count() }} Akun Terdaftar</span></p>
                </div>
                <button onclick="openAddModal()" type="button" class="bg-purple-600 hover:bg-purple-700 text-white text-sm font-bold py-2.5 px-5 rounded-xl shadow-md transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Akun Baru
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100/75 text-gray-600 text-xs uppercase tracking-wider border-b border-gray-200">
                            <th class="p-4 font-bold text-center">ID</th>
                            <th class="p-4 font-bold">Username / Nama</th>
                            <th class="p-4 font-bold">Email</th>
                            <th class="p-4 font-bold text-center">Role / Hak Akses</th>
                            <th class="p-4 font-bold text-center">Tanggal Dibuat</th>
                            <th class="p-4 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-gray-100">
                        @forelse($users as $u)
                        <tr class="hover:bg-gray-50 transition {{ $u->id === auth()->id() ? 'bg-blue-50/30' : '' }}">
                            <td class="p-4 align-middle text-center text-xs font-mono text-gray-400">
                                #{{ $u->id }}
                            </td>

                            <td class="p-4 align-middle">
                                <p class="font-bold text-gray-900 flex items-center gap-2">
                                    {{ $u->name }}
                                    @if($u->id === auth()->id())
                                        <span class="bg-blue-100 text-blue-800 text-[10px] font-black px-2 py-0.5 rounded-full">Anda</span>
                                    @endif
                                </p>
                            </td>

                            <td class="p-4 align-middle text-gray-600 text-xs">
                                {{ $u->email ?: '-' }}
                            </td>

                            <td class="p-4 align-middle text-center">
                                @if($u->isSuperadmin())
                                    <span class="inline-flex items-center gap-1.5 bg-blue-100 text-blue-800 border border-blue-300 py-1 px-3 rounded-full text-xs font-extrabold shadow-sm">
                                        👑 Superadmin
                                    </span>
                                @elseif($u->isDoorprizeAdmin())
                                    <span class="inline-flex items-center gap-1.5 bg-purple-100 text-purple-800 border border-purple-300 py-1 px-3 rounded-full text-xs font-extrabold shadow-sm">
                                        🎁 Petugas Doorprize
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 bg-emerald-100 text-emerald-800 border border-emerald-300 py-1 px-3 rounded-full text-xs font-extrabold shadow-sm">
                                        🎒 Petugas Racepack
                                    </span>
                                @endif
                            </td>

                            <td class="p-4 align-middle text-center text-xs text-gray-500 font-mono">
                                {{ $u->created_at ? $u->created_at->timezone('Asia/Makassar')->format('d/m/Y H:i') . ' WITA' : '-' }}
                            </td>

                            <td class="p-4 align-middle text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <!-- Tombol Edit -->
                                    <button type="button" 
                                            onclick="openEditModal({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ addslashes($u->email ?? '') }}', '{{ $u->role ?: 'superadmin' }}')" 
                                            class="bg-amber-500 hover:bg-amber-600 text-white p-2 rounded-lg transition shadow-sm" title="Edit Akun">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>

                                    <!-- Tombol Hapus -->
                                    @if($u->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" 
                                              onsubmit="return confirm('PERINGATAN! Anda yakin ingin menghapus akun admin [{{ $u->name }}]? Tindakan ini permanen.');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-lg transition shadow-sm" title="Hapus Akun">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-500">
                                Tidak ada akun admin.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal Tambah Akun Baru -->
    <div id="addModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-75 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-6 relative">
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
                    <span>✨</span> Tambah Akun Admin Baru
                </h3>
                <button onclick="closeAddModal()" type="button" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Nama / Username Login <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required placeholder="Contoh: petugas1" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-purple-500 outline-none">
                    <p class="text-[11px] text-gray-400 mt-1">Digunakan untuk login di halaman admin.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Email (Opsional)</label>
                    <input type="email" name="email" placeholder="Contoh: petugas1@gmail.com" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-purple-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password" required minlength="6" placeholder="Minimal 6 karakter" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-purple-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Role / Hak Akses <span class="text-red-500">*</span></label>
                    <select name="role" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-purple-500 outline-none bg-white font-bold">
                        <option value="admin_doorprize">🎁 Petugas Doorprize (Khusus Pengundian Hadiah)</option>
                        <option value="admin_racepack" selected>🎒 Petugas Racepack (Khusus Manajemen Racepack)</option>
                        <option value="superadmin">👑 Superadmin (Akses Penuh Seluruh Sistem)</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeAddModal()" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-bold text-sm hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-sm shadow-md transition">
                        Simpan Akun
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Akun -->
    <div id="editModal" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-75 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-6 relative">
            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-5">
                <h3 class="text-lg font-black text-gray-900 flex items-center gap-2">
                    <span>✏️</span> Edit Akun Admin
                </h3>
                <button onclick="closeEditModal()" type="button" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form id="editForm" action="" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Nama / Username Login <span class="text-red-500">*</span></label>
                    <input type="text" id="editName" name="name" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-amber-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Email (Opsional)</label>
                    <input type="email" id="editEmail" name="email" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-amber-500 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Password Baru (Opsional)</label>
                    <input type="password" name="password" minlength="6" placeholder="Kosongkan jika tidak ingin mengganti password" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-amber-500 outline-none">
                    <p class="text-[11px] text-gray-400 mt-1">Isi hanya jika ingin mengubah password akun ini.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Role / Hak Akses <span class="text-red-500">*</span></label>
                    <select id="editRole" name="role" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-amber-500 outline-none bg-white font-bold">
                        <option value="admin_doorprize">🎁 Petugas Doorprize (Khusus Pengundian Hadiah)</option>
                        <option value="admin_racepack">🎒 Petugas Racepack (Khusus Manajemen Racepack)</option>
                        <option value="superadmin">👑 Superadmin (Akses Penuh Seluruh Sistem)</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-bold text-sm hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-sm shadow-md transition">
                        Perbarui Akun
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }
        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        function openEditModal(id, name, email, role) {
            const form = document.getElementById('editForm');
            form.action = "{{ url('/admin-panel/users') }}/" + id;
            document.getElementById('editName').value = name;
            document.getElementById('editEmail').value = email;
            document.getElementById('editRole').value = role;
            document.getElementById('editModal').classList.remove('hidden');
        }
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAddModal();
                closeEditModal();
            }
        });
    </script>

</body>
</html>
