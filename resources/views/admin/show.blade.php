<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Peserta - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased min-h-screen pb-12">

    <nav class="bg-gray-900 text-white shadow-md">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center font-bold text-lg tracking-wider uppercase">
                    <span class="text-blue-500 mr-2">⚙️</span> DETAIL PESERTA
                </div>
                <a href="{{ route('admin.dashboard') }}" class="text-sm bg-gray-700 hover:bg-gray-600 px-4 py-2 rounded transition">
                    &larr; Kembali
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-4 py-8">
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-blue-600 p-6 text-white flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-bold uppercase tracking-wider">Formulir Registrasi</h2>
                    <p class="text-blue-100 text-sm mt-1">Status: <span class="font-bold text-white bg-white/20 px-2 py-1 rounded">{{ strtoupper($registration->payment_status == 'paid' ? 'LUNAS' : 'PENDING') }}</span></p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-blue-100 uppercase mb-1">Kode Booking</p>
                    <p class="text-2xl font-mono font-bold">{{ $registration->registration_code }}</p>
                </div>
            </div>

            <div class="p-8 space-y-8">
                
                <div>
                    <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Informasi Tiket & Lomba</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Kategori Tiket</label>
                            <input type="text" readonly value="{{ $registration->ticket_category }}" class="w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-100 text-gray-700 font-bold outline-none cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nomor BIB (Dada)</label>
                            <input type="text" readonly value="{{ $registration->bib_number ? sprintf('%04d', $registration->bib_number) : 'Belum Diberikan' }}" class="w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-100 text-blue-700 font-black outline-none cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama BIB (Dada)</label>
                            <input type="text" readonly value="{{ $registration->bib_name ?: '-' }}" class="w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-100 text-blue-700 font-black outline-none cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Ukuran Jersey</label>
                            <input type="text" readonly value="{{ $registration->jersey_size ?: '-' }}" class="w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-100 text-gray-700 outline-none cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Komunitas / Klub</label>
                            <input type="text" readonly value="{{ $registration->community ?? '-' }}" class="w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-100 text-gray-700 outline-none cursor-not-allowed">
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Data Identitas Pribadi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Lengkap</label>
                            <input type="text" readonly value="{{ $registration->full_name }}" class="w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-100 text-gray-700 outline-none cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nomor Identitas (KTP/NIK)</label>
                            <input type="text" readonly value="{{ $registration->identity_number }}" class="w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-100 text-gray-700 outline-none cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Jenis Kelamin</label>
                            <input type="text" readonly value="{{ $registration->gender }}" class="w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-100 text-gray-700 outline-none cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tempat Lahir</label>
                            <input type="text" readonly value="{{ $registration->birth_place }}" class="w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-100 text-gray-700 outline-none cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tanggal Lahir & Usia</label>
                            <input type="text" readonly value="{{ \Carbon\Carbon::parse($registration->birth_date)->format('d F Y') }} ({{ $registration->age }} Tahun)" class="w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-100 text-gray-700 outline-none cursor-not-allowed">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Alamat Lengkap</label>
                            <textarea readonly rows="2" class="w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-100 text-gray-700 outline-none cursor-not-allowed resize-none">{{ $registration->address }}</textarea>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Kontak & Informasi Darurat</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nomor WhatsApp</label>
                            <input type="text" readonly value="{{ $registration->whatsapp }}" class="w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-100 text-gray-700 outline-none cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Email</label>
                            <input type="text" readonly value="{{ $registration->email }}" class="w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-100 text-gray-700 outline-none cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Kontak Darurat</label>
                            <input type="text" readonly value="{{ $registration->emergency_name }} ({{ $registration->emergency_relation }})" class="w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-100 text-red-700 font-semibold outline-none cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">No. Telp Darurat</label>
                            <input type="text" readonly value="{{ $registration->emergency_phone }}" class="w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-100 text-red-700 font-semibold outline-none cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Golongan Darah</label>
                            <input type="text" readonly value="{{ strtoupper($registration->blood_type ?? '-') }}" class="w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-100 text-red-700 font-bold outline-none cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Riwayat Penyakit Medis</label>
                            <input type="text" readonly value="{{ $registration->medical_history ?? 'Tidak Ada' }}" class="w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-100 text-gray-700 outline-none cursor-not-allowed">
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</body>
</html>