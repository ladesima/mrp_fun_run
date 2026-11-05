<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MRP Fun Run 2026 - Kabupaten Jeneponto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Efek scroll halus ketika tombol 'Daftar Sekarang' diklik */
        html { scroll-behavior: smooth; }
        
        /* Tambahan untuk transisi halus slider */
        .slide-bg { transition: opacity 1.5s ease-in-out; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased min-h-screen flex flex-col">

    @php
        // Seluruh Kuota Resmi Ditutup (Reguler & Finisher Package Penuh)
        $isRegularFull = true;
        $isFinisherFull = true;
        $isFinisher5kFull = true;
        $isFinisher10kFull = true;
        $isFull = true; // Kompatibilitas kartu reguler
        $finisher5kRemaining = 0;
        $finisher10kRemaining = 0;
        $totalFinisherRemaining = 0;
    @endphp

    @if(session('error'))
        <div class="bg-red-600 text-white text-center py-3 px-4 font-bold shadow-md relative z-50">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    <div class="bg-red-600 text-white text-center py-2.5 px-4 font-bold uppercase tracking-wider text-sm shadow-md relative z-50">
        🚨 Pengumuman: Pendaftaran MRP Fun Run 2026 Resmi Ditutup! Seluruh Kuota Peserta Telah Terpenuhi.
    </div>

   <header class="text-white pt-12 pb-20 px-4 text-center shadow-lg relative overflow-hidden bg-gray-900">
        
        <div id="hero-slider" class="absolute inset-0 z-0">
            <div class="slide-bg absolute inset-0 bg-cover bg-center bg-no-repeat opacity-100" style="background-image: url('{{ asset('images/slide1.png') }}');"></div>
            <div class="slide-bg absolute inset-0 bg-cover bg-center bg-no-repeat opacity-0" style="background-image: url('{{ asset('images/slide2.png') }}');"></div>
            <div class="slide-bg absolute inset-0 bg-cover bg-center bg-no-repeat opacity-0" style="background-image: url('{{ asset('images/slide3.png') }}');"></div>

            <div class="absolute inset-0 bg-blue-900/70 mix-blend-multiply"></div>
            
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-gray-900/40 to-gray-900"></div>
            
            </div>

        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 opacity-10">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-white rounded-full blur-3xl"></div>
            <div class="absolute top-1/2 right-0 w-64 h-64 bg-white rounded-full blur-3xl"></div>
        </div>

        <div class="relative z-10">
            <img src="{{ asset('images/MRP.png') }}" 
                 alt="Logo MRP Fun Run" 
                 class="mx-auto h-48 md:h-64 object-contain mb-6 drop-shadow-xl">
            
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4 uppercase tracking-wide drop-shadow-md">
                MRP Fun Run 2026
            </h1>
            <p class="text-xl md:text-2xl font-semibold mb-2 text-blue-100">Kabupaten Jeneponto</p>
            <p class="mt-4 text-white max-w-2xl mx-auto font-medium">
                Persiapkan diri Anda untuk event lari terbesar di Jeneponto!
            </p>

            <div class="mt-10 flex flex-col sm:flex-row justify-center items-center gap-4 max-w-md mx-auto sm:max-w-none">
                
                <span class="w-full sm:w-auto bg-gray-600/90 border border-gray-500 text-gray-200 font-extrabold py-4 px-8 rounded-full shadow-md cursor-not-allowed flex items-center justify-center gap-2">
                    🚫 Pendaftaran Resmi Ditutup (Kuota Penuh)
                </span>

                <a href="{{ route('check.status') }}" class="w-full sm:w-auto bg-transparent border-2 border-white text-white font-bold py-4 px-8 rounded-full hover:bg-white hover:text-blue-700 transition duration-300 flex items-center justify-center">
                    🔍 Cek Status / Tiket
                </a>
            </div>
            
            <div class="mt-6 flex flex-col items-center justify-center gap-2">
                <span class="inline-flex items-center gap-2 bg-red-800/80 border border-red-500/50 text-white text-xs md:text-sm font-black px-5 py-2 rounded-full uppercase tracking-wider shadow-lg backdrop-blur-sm">
                    <span>🔒</span> Seluruh Kuota Event Telah Terpenuhi (100% Sold Out)
                </span>
            </div>
            
            <p class="text-xs text-blue-200 mt-2">Sudah mendaftar tapi lupa bayar/unduh tiket? Klik Cek Status.</p>
        </div>
    </header>

    <main class="flex-grow">
        <section class="max-w-5xl mx-auto px-4 pt-16 pb-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-2">Informasi Acara</h2>
            <div class="h-1 w-20 bg-blue-600 mx-auto mb-10 rounded"></div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-6 text-sm text-gray-600">
                <div class="flex flex-col items-center group cursor-pointer">
                    <div class="w-16 h-16 rounded-full border-2 border-blue-200 bg-white flex items-center justify-center mb-3 shadow-sm transform transition-all duration-300 group-hover:-translate-y-2 group-hover:shadow-lg group-hover:border-blue-500">
                        <svg class="w-8 h-8 text-blue-600 transition-colors duration-300 group-hover:text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <p class="font-bold text-gray-800 text-base mb-1 transition-colors duration-300 group-hover:text-blue-600">Tanggal</p>
                    <p>30 Agustus 2026</p>
                </div>
                
                <div class="flex flex-col items-center group cursor-pointer">
                    <div class="w-16 h-16 rounded-full border-2 border-blue-200 bg-white flex items-center justify-center mb-3 shadow-sm transform transition-all duration-300 group-hover:-translate-y-2 group-hover:shadow-lg group-hover:border-blue-500">
                        <svg class="w-8 h-8 text-blue-600 transition-colors duration-300 group-hover:text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="font-bold text-gray-800 text-base mb-1 transition-colors duration-300 group-hover:text-blue-600">Waktu</p>
                    <p>05:30 - WITA</p>
                </div>
                
                <div class="flex flex-col items-center group cursor-pointer">
                    <div class="w-16 h-16 rounded-full border-2 border-blue-200 bg-white flex items-center justify-center mb-3 shadow-sm transform transition-all duration-300 group-hover:-translate-y-2 group-hover:shadow-lg group-hover:border-blue-500">
                        <svg class="w-8 h-8 text-blue-600 transition-colors duration-300 group-hover:text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <p class="font-bold text-gray-800 text-base mb-1 transition-colors duration-300 group-hover:text-blue-600">Lokasi</p>
                    <p>Taman Turatea, Kec. Binamu, Kab. Jeneponto</p>
                </div>
                
                <div class="flex flex-col items-center group cursor-pointer">
                    <div class="w-16 h-16 rounded-full border-2 border-blue-200 bg-white flex items-center justify-center mb-3 shadow-sm transform transition-all duration-300 group-hover:-translate-y-2 group-hover:shadow-lg group-hover:border-blue-500">
                        <svg class="w-8 h-8 text-blue-600 transition-colors duration-300 group-hover:text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <p class="font-bold text-gray-800 text-base mb-1 transition-colors duration-300 group-hover:text-blue-600">List Peserta</p>
                    <a href="{{ route('participants.list') }}" class="text-blue-600 hover:underline">Klik Disini</a>
                </div>
                
                <div class="flex flex-col items-center group">
                    <div class="w-16 h-16 rounded-full border-2 border-blue-200 bg-white flex items-center justify-center mb-3 shadow-sm transform transition-all duration-300 group-hover:-translate-y-2 group-hover:shadow-lg group-hover:border-blue-500 cursor-pointer">
                        <svg class="w-8 h-8 text-blue-600 transition-colors duration-300 group-hover:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <p class="font-bold text-gray-800 text-base mb-1 transition-colors duration-300 group-hover:text-blue-600">WhatsApp</p>
                    
                    <a href="https://wa.me/6281340838388?text=Halo%20Panitia%20MRP%20Fun%20Run%202026,%20saya%20ingin%20bertanya%20seputar%20event..." target="_blank" class="hover:text-green-500 font-semibold transition-colors flex items-center gap-1">
                        +62 813 4083 8388
                    </a>
                    <a href="https://wa.me/6285399996807?text=Halo%20Panitia%20MRP%20Fun%20Run%202026,%20saya%20ingin%20bertanya%20seputar%20event..." target="_blank" class="hover:text-green-500 font-semibold transition-colors flex items-center gap-1 mt-1">
                        +62 853 9999 6807
                    </a>
                </div>
            </div>
        </section>

        <section class="max-w-5xl mx-auto px-4 mb-16">
            <div class="bg-white rounded-xl border border-gray-200 p-8 md:p-10 text-center text-gray-700 leading-relaxed shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-50 rounded-full opacity-50"></div>
                <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-20 h-20 bg-blue-50 rounded-full opacity-50"></div>
                
                <h3 class="text-2xl font-bold text-blue-600 mb-2 uppercase relative z-10">TENTANG MRP FUN RUN 2026</h3>
                <p class="font-semibold text-gray-500 mb-6 uppercase relative z-10">Kabupaten Jeneponto, Sulawesi Selatan</p>
                
                <p class="mb-4 text-justify md:text-center text-sm md:text-base relative z-10">
                    Hallo, Runners! <br><br>
                    MRP Fun Run kembali hadir bagi runners semua. Tahun ini, kategori lomba terdiri dari 5K dan 10K, mengingat tingginya peminat olahraga lari di Kabupaten Jeneponto dan sekitarnya. Event ini diharapkan menjadi wadah silaturahmi sekaligus mempromosikan gaya hidup sehat.
                </p>
                <p class="text-justify md:text-center text-sm md:text-base relative z-10">
                    Peserta akan mendapatkan fasilitas lengkap mulai dari Racepack, BIB Number, hingga Jersey Event. Selain memperebutkan Hadiah Podium, peserta juga berkesempatan mengikuti Doorprize Menarik dan memenangkan <b class="text-blue-700">Hadiah Utama Umroh</b>.
                </p>
            </div>
        </section>

        <section id="kategori-tiket" class="max-w-7xl mx-auto px-4 mb-16 pt-8">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-bold text-gray-900">Kategori Tiket</h2>
                <div class="h-1 w-20 bg-blue-600 mx-auto mt-4 rounded"></div>
            </div>

            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 flex flex-col transform transition-all duration-500 hover:scale-105 hover:shadow-2xl">
                    <div class="bg-gray-900 text-white text-center py-4">
                        <h3 class="text-2xl font-bold uppercase tracking-wider">Regular - 5K</h3>
                    </div>
                    <div class="p-8 flex-grow">
                        <p class="text-4xl font-extrabold text-blue-600 mb-6">Rp175.000</p>
                        <h4 class="font-bold mb-3 text-gray-700">Fasilitas Peserta:</h4>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-center"><span class="text-green-500 mr-2">✅</span> 1 Paket Racepack</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✅</span> Refreshment</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✅</span> <b>Podium</b></li>
                        </ul>
                        <ul class="list-disc pl-5 space-y-1 text-sm text-gray-600">
                            <li>Tiket berlaku untuk 1 orang peserta.</li>
                            <li>Tiket non-refundable.</li>
                        </ul>
                    </div>
                    <div class="p-6 bg-gray-50 border-t border-gray-100 mt-auto">
                        @if($isFull)
                            <span class="block w-full text-center bg-gray-400 text-white font-bold py-3 px-4 rounded-lg cursor-not-allowed">
                                🚫 Kuota Habis
                            </span>
                        @else
                            <a href="{{ route('register.form', ['kategori' => '5k']) }}" class="block w-full text-center bg-gray-900 hover:bg-gray-800 text-white font-bold py-3 px-4 rounded-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
                                Daftar 5K Sekarang
                            </a>
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 flex flex-col transform transition-all duration-500 hover:scale-105 hover:shadow-2xl">
                    <div class="bg-blue-600 text-white text-center py-4">
                        <h3 class="text-2xl font-bold uppercase tracking-wider">Regular - 10K</h3>
                    </div>
                    <div class="p-8 flex-grow">
                        <p class="text-4xl font-extrabold text-blue-600 mb-6">Rp200.000</p>
                        <h4 class="font-bold mb-3 text-gray-700">Fasilitas Peserta:</h4>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-center"><span class="text-green-500 mr-2">✅</span> 1 Paket Racepack</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✅</span> Refreshment</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✅</span> <b>Podium</b></li>
                        </ul>
                        <ul class="list-disc pl-5 space-y-1 text-sm text-gray-600">
                            <li>Tiket berlaku untuk 1 orang peserta.</li>
                            <li>Tiket non-refundable.</li>
                        </ul>
                    </div>
                    <div class="p-6 bg-gray-50 border-t border-gray-100 mt-auto">
                        @if($isFull)
                            <span class="block w-full text-center bg-gray-400 text-white font-bold py-3 px-4 rounded-lg cursor-not-allowed">
                                🚫 Kuota Habis
                            </span>
                        @else
                            <a href="{{ route('register.form', ['kategori' => '10k']) }}" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
                                Daftar 10K Sekarang
                            </a>
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 flex flex-col transform transition-all duration-500 hover:scale-105 hover:shadow-2xl">
                    <div class="bg-emerald-600 text-white text-center py-4">
                        <h3 class="text-2xl font-bold uppercase tracking-wider">Finisher Package</h3>
                    </div>
                    <div class="p-8 flex-grow">
                        <p class="text-4xl font-extrabold text-emerald-600 mb-6">Rp100.000</p>
                        <h4 class="font-bold mb-3 text-gray-700">Fasilitas Peserta:</h4>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-center"><span class="text-green-500 mr-2">✅</span> 1 Paket Racepack</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✅</span> Refreshment</li>
                            <li class="flex items-center"><span class="text-green-500 mr-2">✅</span> <b>Podium</b></li>
                        </ul>
                        <ul class="list-disc pl-5 space-y-1 text-sm text-gray-600">
                            <li>Tiket berlaku untuk 1 orang peserta.</li>
                            <li>
                                <b>Kategori 5K:</b> 
                                @if($isFinisher5kFull)
                                    <span class="text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded font-bold">KUOTA PENUH</span>
                                @else
                                    <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded font-bold">Tersisa {{ $finisher5kRemaining }} Slot</span>
                                @endif
                            </li>
                            <li>
                                <b>Kategori 10K:</b> 
                                @if($isFinisher10kFull)
                                    <span class="text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded font-bold">KUOTA PENUH</span>
                                @else
                                    <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded font-bold">Tersisa {{ $finisher10kRemaining }} Slot</span>
                                @endif
                            </li>
                            <li>Tiket non-refundable.</li>
                        </ul>
                    </div>
                    <div class="p-6 bg-gray-50 border-t border-gray-100 mt-auto">
                        @if($isFinisherFull)
                            <span class="block w-full text-center bg-gray-400 text-white font-bold py-3 px-4 rounded-lg cursor-not-allowed">
                                🚫 Kuota Habis
                            </span>
                        @else
                            <a href="{{ route('register.form', ['kategori' => 'finisher']) }}" class="block w-full text-center bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-lg transform transition-all duration-300 hover:-translate-y-1 hover:shadow-md">
                                Daftar Finisher Sekarang
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </section>

        <section class="bg-white py-12 px-4 border-t border-gray-200">
            <div class="max-w-3xl mx-auto bg-gray-50 rounded-xl shadow-sm p-8 border-l-4 border-yellow-500">
                <h3 class="text-xl font-bold mb-4 text-gray-800 flex items-center">
                    <span class="mr-2">⚠️</span> INFORMASI PENTING
                </h3>
                <ul class="space-y-3 text-gray-700">
                    <li class="flex items-start"><span class="mr-2">📌</span> Pastikan data peserta diisi dengan benar saat pembelian tiket.</li>
                    <li class="flex items-start"><span class="mr-2">📌</span> Simpan dengan baik Nomor WhatsApp dan NIK (KTP) yang Anda gunakan mendaftar untuk keperluan cek status tiket.</li>
                    <li class="flex items-start"><span class="mr-2">📌</span> Kuota peserta terbatas dan pendaftaran dapat ditutup sewaktu-waktu.</li>
                </ul>
            </div>
        </section>
        
        <section class="bg-white py-16 px-4 text-center border-t border-gray-100">
            <div class="max-w-5xl mx-auto">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-[0.2em] mb-10">Sponsored By</h3>
                
                <div class="flex flex-wrap justify-center items-center gap-8 md:gap-12">
    
    <div class="bg-gray-900 rounded-2xl p-6 shadow-xl hover:scale-105 transition duration-300">
        <img src="{{ asset('images/jepot.png') }}" alt="Sponsor Lapak Turatea" class="h-12 md:h-16 object-contain">
    </div>
    <div class="bg-gray-900 rounded-2xl p-6 shadow-xl hover:scale-105 transition duration-300">
        <img src="{{ asset('images/bank.png') }}" alt="Sponsor Lapak Turatea" class="h-12 md:h-16 object-contain">
    </div>
    <div class="bg-gray-900 rounded-2xl p-6 shadow-xl hover:scale-105 transition duration-300">
        <img src="{{ asset('images/LAPAK.png') }}" alt="Sponsor Lapak Turatea" class="h-12 md:h-16 object-contain">
    </div>
    
    <div class="bg-gray-900 rounded-2xl p-6 shadow-xl hover:scale-105 transition duration-300">
        <img src="{{ asset('images/Anugrahjaya2.png') }}" alt="Sponsor Anugrah Jaya" class="h-12 md:h-16 object-contain">
    </div>
    
    <div class="bg-gray-900 rounded-2xl p-6 shadow-xl hover:scale-105 transition duration-300">
        <img src="{{ asset('images/PTfauziah.png') }}" alt="Sponsor fz" class="h-12 md:h-16 object-contain">
    </div>
    
    <div class="bg-gray-900 rounded-2xl p-6 shadow-xl hover:scale-105 transition duration-300">
        <img src="{{ asset('images/sponsorbru.png') }}" alt="Sponsor bru" class="h-12 md:h-16 object-contain">
    </div>
    
    <div class="bg-gray-900 rounded-2xl p-6 shadow-xl hover:scale-105 transition duration-300">
        <img src="{{ asset('images/tecno.jpeg') }}" alt="Sponsor Tecno" class="h-12 md:h-16 object-contain">
    </div>
    
</div>
            </div>
        </section>

    </main>

    <footer class="bg-gray-950 text-gray-400 py-10 text-center mt-auto">
        <div class="max-w-5xl mx-auto px-4 flex flex-col items-center">
            
            <div class="flex justify-center items-center gap-6 mb-6">
                <img src="{{ asset('images/MRP.png') }}" alt="Logo MRP" class="h-14 opacity-50 grayscale hover:grayscale-0 transition duration-500">
                <img src="{{ asset('images/logoresmi.png') }}" alt="Logo Resmi" class="h-14 opacity-50 grayscale hover:grayscale-0 transition duration-500">
            </div>
            
            <p class="text-sm text-gray-300 font-medium tracking-wide mb-1">&copy; 2026 MRP Fun Run - Kabupaten Jeneponto.</p>
            <p class="text-xs text-gray-500 mb-6">All rights reserved.</p>
            
            <div class="border-t border-gray-800 pt-6 w-full max-w-xs mx-auto">
                <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Developed By</p>
                <p class="text-sm font-bold text-gray-300">Muhammad Musyary, S.Kom.</p>
            </div>
            
            <a href="{{ url('/admin-login') }}" class="inline-flex items-center mt-8 text-gray-500 hover:text-white text-xs font-black tracking-widest uppercase transition bg-gray-900 hover:bg-gray-800 px-5 py-2.5 rounded-full border border-gray-800">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                Admin Area
            </a>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const slides = document.querySelectorAll('.slide-bg');
            let currentSlide = 0;

            if(slides.length > 1) {
                setInterval(() => {
                    slides[currentSlide].classList.remove('opacity-100');
                    slides[currentSlide].classList.add('opacity-0');
                    
                    currentSlide = (currentSlide + 1) % slides.length;
                    
                    slides[currentSlide].classList.remove('opacity-0');
                    slides[currentSlide].classList.add('opacity-100');
                }, 4000); // 4000ms = 4 detik per foto
            }
        });
    </script>
</body>
</html>