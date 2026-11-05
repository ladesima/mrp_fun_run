<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi {{ $kategori }} - MRP Fun Run 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Animasi kustom untuk transisi input yang mulus */
        .input-transition {
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 via-gray-100 to-gray-200 text-gray-800 font-sans antialiased min-h-screen py-12 relative overflow-x-hidden">

    <div class="absolute top-0 left-0 w-96 h-96 bg-blue-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 translate-x-1/3 translate-y-1/3 pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-4 relative z-10">
        
        <div class="text-center mb-10">
            <div class="inline-block p-4 bg-white rounded-full shadow-md mb-4 border border-blue-100">
                 <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <h1 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-700 to-blue-500 uppercase tracking-widest drop-shadow-sm">
                Formulir Pendaftaran
            </h1>
            <p class="text-gray-500 mt-2 font-medium tracking-wide">MRP FUN RUN 2026 – KABUPATEN JENEPONTO</p>
            
            <div class="mt-6 inline-flex items-center bg-white border border-blue-200 text-blue-800 px-6 py-2 rounded-full font-bold text-lg shadow-sm">
                <span class="mr-2 px-3 py-1 bg-blue-600 text-white rounded-full text-sm">KATEGORI</span>
                {{ $kategori }} (Rp{{ number_format($harga, 0, ',', '.') }})
            </div>
        </div>

        <form action="{{ route('register.submit') }}" method="POST" class="space-y-8">
            @csrf
            
            <input type="hidden" name="ticket_category" value="{{ $kategori }}">
            <input type="hidden" name="price" value="{{ $harga }}">

            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-gray-100 relative overflow-hidden group">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-blue-500 rounded-l-2xl transition-all duration-300 group-hover:w-2"></div>
                
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="bg-blue-100 text-blue-600 w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">1</span>
                    DATA DIRI PESERTA
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Nama Lengkap (Sesuai KTP/Identitas) <span class="text-red-500">*</span></label>
                        <input type="text" name="full_name" required class="w-full px-5 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none input-transition shadow-sm" placeholder="Masukkan nama lengkap">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <select name="gender" required class="w-full px-5 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none input-transition shadow-sm">
                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Tanggal Lahir <span class="text-red-500">*</span></label>
                        <input type="date" name="birth_date" id="birth_date" required class="w-full px-5 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none input-transition shadow-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Usia <span class="text-red-500">*</span></label>
                        <div class="flex items-center shadow-sm rounded-lg overflow-hidden border border-gray-200 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 input-transition">
                            <input type="number" name="age" id="age" readonly required placeholder="Terisi otomatis..." class="w-full px-5 py-3 border-none bg-gray-100 text-gray-600 focus:ring-0 outline-none cursor-not-allowed">
                            <span class="bg-gray-200 px-5 py-3 font-semibold text-gray-600 border-l border-gray-300">Tahun</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Tempat Lahir <span class="text-red-500">*</span></label>
                        <input type="text" name="birth_place" required class="w-full px-5 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none input-transition shadow-sm" placeholder="Kota/Kabupaten">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Nomor HP / WhatsApp Aktif <span class="text-red-500">*</span></label>
                        <input type="number" name="whatsapp" required class="w-full px-5 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none input-transition shadow-sm" placeholder="Contoh: 08123456789">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Email Aktif (Opsional)</label>
                        <input type="email" name="email" class="w-full px-5 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none input-transition shadow-sm" placeholder="email@contoh.com">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Alamat Lengkap / Domisili <span class="text-red-500">*</span></label>
                        <textarea name="address" rows="3" required class="w-full px-5 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none input-transition shadow-sm" placeholder="Masukkan alamat lengkap"></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Nomor Identitas (KTP/SIM/Pelajar) <span class="text-red-500">*</span></label>
                        <input type="number" name="identity_number" required class="w-full px-5 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none input-transition shadow-sm" placeholder="Nomor identitas yang berlaku">
                    </div>
                </div>
            </div>

            <!--<div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-gray-100 text-center">-->
            <!--    <h3 class="text-lg font-bold text-gray-800 mb-4 uppercase tracking-wider">Panduan Ukuran Jersey</h3>-->
            <!--    <div class="max-w-2xl mx-auto border-2 border-gray-100 rounded-xl overflow-hidden shadow-sm">-->
            <!--        <img src="{{ asset('images/ukuran.jpeg') }}" alt="Panduan Ukuran Jersey" class="w-full h-auto">-->
            <!--    </div>-->
            <!--    <p class="text-sm text-gray-500 mt-3 italic">Silakan jadikan gambar di atas sebagai referensi sebelum memilih ukuran jersey Anda.</p>-->
            <!--</div>-->

            @php
                $isFinisher = ($kategori === 'FINISHER PACKAGE' || str_contains(strtoupper($kategori), 'FINISHER'));
            @endphp

            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-gray-100 relative overflow-hidden group">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-blue-500 rounded-l-2xl transition-all duration-300 group-hover:w-2"></div>
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="bg-blue-100 text-blue-600 w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">2</span>
                    DATA EVENT
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($isFinisher)
                        @php
                            $totalPaidAll = \App\Models\Registration::where('payment_status', 'paid')->count();
                            $totalEventRemaining = max(0, 1500 - $totalPaidAll);
                            $fin5kNewPaid = $finisher5kCount ?? \App\Models\Registration::where('payment_status', 'paid')
                                ->where('ticket_category', 'like', '%Finisher%5K%')
                                ->where('created_at', '>=', '2026-08-27 00:00:00')
                                ->count();
                            $fin10kNewPaid = $finisher10kCount ?? \App\Models\Registration::where('payment_status', 'paid')
                                ->where('ticket_category', 'like', '%Finisher%10K%')
                                ->where('created_at', '>=', '2026-08-27 00:00:00')
                                ->count();

                            $fin5kRemaining = isset($finisher5kRemaining) ? $finisher5kRemaining : max(0, 60 - $fin5kNewPaid);
                            $fin10kRemaining = isset($finisher10kRemaining) ? $finisher10kRemaining : max(0, 6 - $fin10kNewPaid);
                            $is5kFull = isset($isFinisher5kFull) ? $isFinisher5kFull : (($fin5kRemaining <= 0) || ($totalEventRemaining <= 0));
                            $is10kFull = isset($isFinisher10kFull) ? $isFinisher10kFull : (($fin10kRemaining <= 0) || ($totalEventRemaining <= 0));
                        @endphp
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Pilihan Kategori Jarak <span class="text-red-500">*</span></label>
                            <select name="distance_category" required class="w-full px-5 py-3 rounded-lg border border-blue-300 bg-white text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none input-transition shadow-sm font-bold">
                                <option value="" disabled selected>Pilih Jarak Lari (5K / 10K)</option>
                                <option value="5K" {{ $is5kFull ? 'disabled' : '' }}>
                                    5K {{ $is5kFull ? '- [KUOTA PENUH]' : '- Sisa ' . $fin5kRemaining . ' Slot' }}
                                </option>
                                <option value="10K" {{ $is10kFull ? 'disabled' : '' }}>
                                    10K {{ $is10kFull ? '- [KUOTA PENUH]' : '- Sisa ' . $fin10kRemaining . ' Slot' }}
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Paket Tiket</label>
                            <div class="w-full px-5 py-3 rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-800 font-bold shadow-sm flex items-center justify-between">
                                <span>Finisher Package</span>
                                <span class="text-xs bg-emerald-600 text-white px-2.5 py-1 rounded-full font-semibold">Tanpa Jersey & Tanpa Custom BIB</span>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Komunitas / Instansi (Opsional)</label>
                            <input type="text" name="community" class="w-full px-5 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none input-transition shadow-sm" placeholder="Nama komunitas atau instansi">
                        </div>
                    @else
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Kategori Lari</label>
                            <div class="w-full px-5 py-3 rounded-lg border border-blue-200 bg-blue-50 text-blue-800 font-bold shadow-sm">
                                {{ $kategori }} (Rp{{ number_format($harga, 0, ',', '.') }})
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Ukuran Jersey <span class="text-red-500">*</span></label>
                            <select name="jersey_size" required class="w-full px-5 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none input-transition shadow-sm">
                                <option value="" disabled selected>Pilih Ukuran</option>
                                <option value="ALL SIZE">ALL SIZE</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Nama pada BIB (Nomor Dada) <span class="text-red-500">*</span></label>
                            <input type="text" name="bib_name" maxlength="15" required placeholder="Maksimal 15 Karakter" class="w-full px-5 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none input-transition shadow-sm">
                            <p class="text-xs text-gray-500 mt-1 italic">Nama yang akan dicetak di nomor dada Anda.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2">Komunitas / Instansi (Opsional)</label>
                            <input type="text" name="community" class="w-full px-5 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none input-transition shadow-sm" placeholder="Nama komunitas atau instansi">
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-gray-100 relative overflow-hidden group">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-blue-500 rounded-l-2xl transition-all duration-300 group-hover:w-2"></div>
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="bg-blue-100 text-blue-600 w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">3</span>
                    KONTAK DARURAT
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Nama Kontak Darurat <span class="text-red-500">*</span></label>
                        <input type="text" name="emergency_name" required class="w-full px-5 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none input-transition shadow-sm" placeholder="Nama orang yang bisa dihubungi">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Hubungan dengan Peserta <span class="text-red-500">*</span></label>
                        <input type="text" name="emergency_relation" required placeholder="Contoh: Orang Tua / Pasangan" class="w-full px-5 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none input-transition shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Nomor HP Kontak Darurat <span class="text-red-500">*</span></label>
                        <input type="number" name="emergency_phone" required class="w-full px-5 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none input-transition shadow-sm" placeholder="Nomor telepon aktif">
                    </div>
                </div>
            </div>

            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-gray-100 relative overflow-hidden group">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-blue-500 rounded-l-2xl transition-all duration-300 group-hover:w-2"></div>
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <span class="bg-blue-100 text-blue-600 w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">4</span>
                    INFORMASI KESEHATAN
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Golongan Darah (Opsional)</label>
                        <select name="blood_type" class="w-full px-5 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none input-transition shadow-sm">
                            <option value="Tidak Tahu" selected>Tidak Tahu</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="AB">AB</option>
                            <option value="O">O</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-600 mb-2">Riwayat Penyakit Khusus (Opsional)</label>
                        <input type="text" name="medical_history" placeholder="Kosongkan jika tidak ada" class="w-full px-5 py-3 rounded-lg border border-gray-200 bg-gray-50 text-gray-800 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none input-transition shadow-sm">
                    </div>
                    
                    <div class="md:col-span-2 mt-4 bg-blue-50 rounded-lg p-5 border border-blue-100">
                        <label class="flex items-start cursor-pointer">
                            <div class="flex-shrink-0 mt-0.5">
                                <input type="checkbox" name="health_declaration" required class="w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                            </div>
                            <span class="ml-3 text-sm font-medium text-gray-800 leading-relaxed">
                                Saya menyatakan dalam kondisi sehat dan siap secara fisik maupun mental untuk mengikuti MRP Fun Run 2026. <span class="text-red-500">*</span>
                            </span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="bg-gray-900 text-white rounded-2xl shadow-xl p-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gray-800 rounded-bl-full opacity-50"></div>
                
                <h2 class="text-xl font-bold mb-6 relative z-10 flex items-center">
                     <svg class="w-6 h-6 mr-2 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    PERSETUJUAN PESERTA
                </h2>
                
                <div class="space-y-5 relative z-10">
                    <label class="flex items-start cursor-pointer group">
                        <div class="flex-shrink-0 mt-0.5">
                            <input type="checkbox" name="terms_agreement" required class="w-5 h-5 rounded border-gray-600 bg-gray-800 text-blue-500 focus:ring-blue-500 focus:ring-offset-gray-900 cursor-pointer">
                        </div>
                        <span class="ml-3 text-sm text-gray-300 group-hover:text-white transition-colors duration-200">
                            Saya telah membaca dan menyetujui seluruh <a href="#" class="text-blue-400 hover:underline">Syarat & Ketentuan</a> MRP Fun Run 2026. <span class="text-red-400">*</span>
                        </span>
                    </label>
                    <label class="flex items-start cursor-pointer group">
                        <div class="flex-shrink-0 mt-0.5">
                            <input type="checkbox" name="media_consent" required class="w-5 h-5 rounded border-gray-600 bg-gray-800 text-blue-500 focus:ring-blue-500 focus:ring-offset-gray-900 cursor-pointer">
                        </div>
                        <span class="ml-3 text-sm text-gray-300 group-hover:text-white transition-colors duration-200">
                            Saya bersedia foto/video selama kegiatan digunakan oleh panitia untuk keperluan dokumentasi dan publikasi event. <span class="text-red-400">*</span>
                        </span>
                    </label>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-between pt-4 pb-8 gap-4">
                <a href="{{ route('home') }}" class="flex items-center text-gray-500 hover:text-blue-600 font-semibold transition-colors duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Halaman Utama
                </a>
                <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 text-white font-bold py-4 px-10 rounded-full shadow-xl hover:shadow-2xl transform transition-all duration-300 hover:-translate-y-1 text-lg flex items-center justify-center">
                    Simpan & Lanjut Pembayaran
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </form>
    </div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const birthDateInput = document.getElementById('birth_date');
        const ageInput = document.getElementById('age');

        birthDateInput.addEventListener('change', function() {
            if (this.value) {
                // Ambil tanggal lahir yang dipilih
                const dob = new Date(this.value);
                
                // Ambil tanggal hari ini (Tahun 2026 sesuai konteks event Anda)
                const today = new Date(); 
                
                // Hitung selisih tahun
                let age = today.getFullYear() - dob.getFullYear();
                
                // Cek apakah bulan dan tanggal ulang tahun belum lewat di tahun ini
                const monthDiff = today.getMonth() - dob.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                    age--; // Kurangi 1 tahun jika ulang tahun belum dirayakan tahun ini
                }

                // Masukkan hasil perhitungan ke kolom usia
                ageInput.value = age;
            } else {
                // Kosongkan usia jika tanggal lahir dihapus
                ageInput.value = '';
            }
        });
    });
</script>
</body>
</html>