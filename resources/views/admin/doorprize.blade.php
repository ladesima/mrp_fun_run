<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Operator Pengundian Doorprize - MRP Fun Run 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #0f172a; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased min-h-screen flex flex-col justify-between selection:bg-blue-600 selection:text-white">

    <!-- Top Navigation Header -->
    <header class="bg-slate-900/90 border-b border-slate-800 backdrop-blur-md sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <div class="flex items-center gap-3">
                    <div class="text-blue-500 font-black text-lg tracking-wider uppercase flex items-center gap-2">
                        <span>⚙️</span> MRP RUN ADMIN
                    </div>
                    <span class="bg-indigo-950/80 text-indigo-300 border border-indigo-700/50 text-xs px-3 py-1 rounded-full font-black uppercase tracking-wider">
                        🎛️ Panel Operator Undian
                    </span>
                    <span class="text-xs text-slate-400 font-bold bg-slate-800/80 px-3 py-1 rounded-full border border-slate-700">
                        👤 {{ auth()->user()->name }} ({{ auth()->user()->isSuperadmin() ? '👑 Superadmin' : (auth()->user()->isDoorprizeAdmin() ? '🎁 Petugas Doorprize' : '🎒 Petugas Racepack') }})
                    </span>
                </div>

                <div class="flex items-center gap-3">
                    <!-- Stage Status Indicator -->
                    <span id="stageStatusBadge" class="bg-amber-950/70 text-amber-300 border border-amber-600/50 text-xs px-3.5 py-1.5 rounded-xl font-bold flex items-center gap-2">
                        <span id="stageDot" class="w-2 h-2 rounded-full bg-amber-400"></span>
                        <span id="stageText">Layar Panggung Belum Dibuka</span>
                    </span>

                    <!-- Launch Stage Display Button -->
                    <button onclick="openStageWindow()" class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white px-4 py-2 rounded-xl text-xs sm:text-sm font-black shadow-lg shadow-purple-900/30 flex items-center gap-2 transition transform active:scale-95">
                        <span>📺</span> Buka Layar Panggung ↗
                    </button>

                    @if(!auth()->user()->isDoorprizeAdmin())
                        <a href="{{ auth()->user()->isSuperadmin() ? route('admin.dashboard') : route('admin.racepack') }}" class="bg-slate-800 hover:bg-slate-700 text-slate-300 px-3.5 py-2 rounded-xl text-xs font-bold border border-slate-700 transition">
                            Kembali
                        </a>
                    @endif

                    <form action="{{ route('admin.logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-rose-900/80 hover:bg-rose-800 text-rose-200 px-3.5 py-2 rounded-xl text-xs font-bold border border-rose-700 transition">
                            Logout
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex-grow w-full">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- LEFT COLUMN: KONFIGURASI & KONTROL SPIN (7 COLS) -->
            <div class="lg:col-span-7 space-y-6">

                <!-- 1. KOTAK KONFIGURASI HADIAH -->
                <div class="bg-slate-900/80 border border-slate-800 rounded-3xl p-5 sm:p-6 shadow-xl backdrop-blur-md">
                    <h3 class="text-sm font-black text-slate-300 uppercase tracking-wider flex items-center gap-2 mb-4">
                        <span>🎁</span> 1. Konfigurasi Hadiah
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">
                <!-- 1. KOTAK PENGATURAN HADIAH -->
                <div class="bg-slate-900/80 border border-slate-800 rounded-3xl p-5 sm:p-6 shadow-xl backdrop-blur-md">
                    <h3 class="text-sm font-black text-slate-300 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span>🎁</span> 1. Pengaturan Hadiah & Jumlah Pemenang
                    </h3>

                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">
                                    Nama Hadiah yang Diundi:
                                </label>
                                <input type="text" id="prizeNameInput" value="10 Kipas Angin" placeholder="Ketik nama hadiah..." class="w-full px-4 py-2.5 bg-slate-950 border border-slate-700 rounded-2xl text-white font-black text-sm sm:text-base focus:ring-2 focus:ring-blue-500 outline-none shadow-inner">
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-amber-400 tracking-wider mb-2">
                                    Undi Sekaligus:
                                </label>
                                <select id="drawCountSelect" onchange="onDrawCountChange()" class="w-full px-3 py-2.5 bg-amber-950/40 border border-amber-500/50 rounded-2xl text-amber-300 font-black text-sm focus:ring-2 focus:ring-amber-500 outline-none">
                                    <option value="1">1 Pemenang (Tunggal)</option>
                                    <option value="2">2 Pemenang Sekaligus</option>
                                    <option value="3">3 Pemenang Sekaligus</option>
                                    <option value="4">4 Pemenang Sekaligus</option>
                                    <option value="5">5 Pemenang Sekaligus</option>
                                    <option value="6">6 Pemenang Sekaligus</option>
                                    <option value="7">7 Pemenang Sekaligus</option>
                                    <option value="8">8 Pemenang Sekaligus</option>
                                    <option value="9">9 Pemenang Sekaligus</option>
                                    <option value="10" selected>10 Pemenang Sekaligus (Maks)</option>
                                </select>
                            </div>
                        </div>

                        <!-- Preset Pilihan Cepat Hadiah Sesuai Daftar -->
                        <div>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Pilihan Cepat Hadiah:</p>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                <button type="button" onclick="setPresetPrize('Kipas Angin', 10)" class="px-2.5 py-2 bg-slate-950 hover:bg-slate-800 text-xs font-bold text-left text-blue-300 rounded-xl border border-slate-800 hover:border-blue-500/50 transition flex items-center justify-between">
                                    <span>🌀  Kipas</span>
                                    <span class="text-[10px] bg-blue-950 text-blue-400 px-1.5 py-0.5 rounded font-mono">10x</span>
                                </button>
                                <button type="button" onclick="setPresetPrize(' Smartphone', 4)" class="px-2.5 py-2 bg-slate-950 hover:bg-slate-800 text-xs font-bold text-left text-purple-300 rounded-xl border border-slate-800 hover:border-purple-500/50 transition flex items-center justify-between">
                                    <span>📱  Handphone</span>
                                    <span class="text-[10px] bg-purple-950 text-purple-400 px-1.5 py-0.5 rounded font-mono">4x</span>
                                </button>
                                <button type="button" onclick="setPresetPrize('Smart TV ', 1)" class="px-2.5 py-2 bg-slate-950 hover:bg-slate-800 text-xs font-bold text-left text-amber-300 rounded-xl border border-slate-800 hover:border-amber-500/50 transition flex items-center justify-between">
                                    <span>📺 TV</span>
                                    <span class="text-[10px] bg-amber-950 text-amber-400 px-1.5 py-0.5 rounded font-mono">1x</span>
                                </button>
                                <button type="button" onclick="setPresetPrize('Mesin Cuci', 1)" class="px-2.5 py-2 bg-slate-950 hover:bg-slate-800 text-xs font-bold text-left text-cyan-300 rounded-xl border border-slate-800 hover:border-cyan-500/50 transition flex items-center justify-between">
                                    <span>🧺 Mesin Cuci</span>
                                    <span class="text-[10px] bg-cyan-950 text-cyan-400 px-1.5 py-0.5 rounded font-mono">1x</span>
                                </button>
                                <button type="button" onclick="setPresetPrize('Kulkas', 1)" class="px-2.5 py-2 bg-slate-950 hover:bg-slate-800 text-xs font-bold text-left text-cyan-300 rounded-xl border border-slate-800 hover:border-cyan-500/50 transition flex items-center justify-between">
                                    <span>❄️ Kulkas</span>
                                    <span class="text-[10px] bg-cyan-950 text-cyan-400 px-1.5 py-0.5 rounded font-mono">1x</span>
                                </button>
                                <button type="button" onclick="setPresetPrize('Setrika', 10)" class="px-2.5 py-2 bg-slate-950 hover:bg-slate-800 text-xs font-bold text-left text-emerald-300 rounded-xl border border-slate-800 hover:border-emerald-500/50 transition flex items-center justify-between">
                                    <span>👕 Setrika</span>
                                    <span class="text-[10px] bg-emerald-950 text-emerald-400 px-1.5 py-0.5 rounded font-mono">10x</span>
                                </button>
                                <button type="button" onclick="setPresetPrize('Speaker', 2)" class="px-2.5 py-2 bg-slate-950 hover:bg-slate-800 text-xs font-bold text-left text-indigo-300 rounded-xl border border-slate-800 hover:border-indigo-500/50 transition flex items-center justify-between">
                                    <span>🔊  Speaker</span>
                                    <span class="text-[10px] bg-indigo-950 text-indigo-400 px-1.5 py-0.5 rounded font-mono">2x</span>
                                </button>
                                <button type="button" onclick="setPresetPrize('Dispenser', 2)" class="px-2.5 py-2 bg-slate-950 hover:bg-slate-800 text-xs font-bold text-left text-indigo-300 rounded-xl border border-slate-800 hover:border-indigo-500/50 transition flex items-center justify-between">
                                    <span>🚰  Dispenser</span>
                                    <span class="text-[10px] bg-indigo-950 text-indigo-400 px-1.5 py-0.5 rounded font-mono">2x</span>
                                </button>
                                <button type="button" onclick="setPresetPrize('Blender', 2)" class="px-2.5 py-2 bg-slate-950 hover:bg-slate-800 text-xs font-bold text-left text-indigo-300 rounded-xl border border-slate-800 hover:border-indigo-500/50 transition flex items-center justify-between">
                                    <span>🍹 Blender</span>
                                    <span class="text-[10px] bg-indigo-950 text-indigo-400 px-1.5 py-0.5 rounded font-mono">2x</span>
                                </button>
                                <button type="button" onclick="setPresetPrize('TWS Earphone', 10)" class="px-2.5 py-2 bg-slate-950 hover:bg-slate-800 text-xs font-bold text-left text-rose-300 rounded-xl border border-slate-800 hover:border-rose-500/50 transition flex items-center justify-between">
                                    <span>🎧  TWS</span>
                                    <span class="text-[10px] bg-rose-950 text-rose-400 px-1.5 py-0.5 rounded font-mono">10x</span>
                                </button>
                                <button type="button" onclick="setPresetPrize('Tumblr', 6)" class="px-2.5 py-2 bg-slate-950 hover:bg-slate-800 text-xs font-bold text-left text-teal-300 rounded-xl border border-slate-800 hover:border-teal-500/50 transition flex items-center justify-between">
                                    <span>🥤  Tumblr</span>
                                    <span class="text-[10px] bg-teal-950 text-teal-400 px-1.5 py-0.5 rounded font-mono">6x</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. KOTAK FILTER & POOL PESERTA -->
                <div class="bg-slate-900/80 border border-slate-800 rounded-3xl p-5 sm:p-6 shadow-xl backdrop-blur-md">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-sm font-black text-slate-300 uppercase tracking-wider flex items-center gap-2">
                            <span>👥</span> 2. Pool Peserta Undian
                        </h3>
                        <button onclick="refreshData()" type="button" class="text-xs bg-slate-800 hover:bg-slate-700 text-blue-400 font-bold px-3 py-1.5 rounded-xl border border-slate-700 transition flex items-center gap-1.5">
                            🔄 Sinkronkan Data Baru
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">
                                Filter Kategori Peserta:
                            </label>
                            <select id="categoryFilter" onchange="applyFilter()" class="w-full px-4 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-white font-bold text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="ALL">Semua Kategori (5K, 10K, Finisher)</option>
                                <option value="5K">5K Reguler Saja</option>
                                <option value="10K">10K Reguler Saja</option>
                                <option value="FINISHER">Finisher Package Saja</option>
                            </select>
                        </div>

                        <div class="bg-slate-950 border border-slate-800 rounded-2xl p-3.5 flex items-center justify-between">
                            <div>
                                <p class="text-[10px] uppercase font-bold text-slate-400">Peserta Siap Diundi:</p>
                                <p class="text-2xl font-black text-emerald-400">
                                    <span id="poolCountText">{{ $totalEligible }}</span> <span class="text-xs text-slate-400 font-normal">Orang</span>
                                </p>
                            </div>
                            <span class="text-xs text-emerald-400 bg-emerald-950/60 border border-emerald-500/40 px-2.5 py-1 rounded-lg font-bold">
                                ✅ Sudah Ambil Racepack
                            </span>
                        </div>
                    </div>
                </div>

                <!-- 3. KOTAK KONTROL UTAMA PENGUNDIAN (SPIN / STOP) -->
                <div class="bg-gradient-to-b from-slate-900 to-slate-950 border-2 border-blue-500/40 rounded-3xl p-6 sm:p-8 text-center shadow-2xl backdrop-blur-md">
                    
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">
                            🎛️ KONTROL SPIN PANGGUNG
                        </span>
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-slate-400 font-medium">Layar Terhubung:</span>
                            <span id="miniConnDot" class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                        </div>
                    </div>

                    <!-- Single / Multi Digital Preview Display -->
                    <div id="singlePreviewContainer" class="bg-slate-950/90 border border-slate-800 rounded-2xl p-4 sm:p-6 mb-6">
                        <div class="flex justify-center items-center gap-2 sm:gap-3 mb-3">
                            <div id="mDigit1" class="w-12 h-16 sm:w-16 sm:h-20 bg-slate-900 border border-blue-500/40 rounded-xl flex items-center justify-center text-3xl sm:text-4xl font-black text-blue-400 font-mono">0</div>
                            <div id="mDigit2" class="w-12 h-16 sm:w-16 sm:h-20 bg-slate-900 border border-blue-500/40 rounded-xl flex items-center justify-center text-3xl sm:text-4xl font-black text-blue-400 font-mono">0</div>
                            <div id="mDigit3" class="w-12 h-16 sm:w-16 sm:h-20 bg-slate-900 border border-blue-500/40 rounded-xl flex items-center justify-center text-3xl sm:text-4xl font-black text-blue-400 font-mono">0</div>
                            <div id="mDigit4" class="w-12 h-16 sm:w-16 sm:h-20 bg-slate-900 border border-blue-500/40 rounded-xl flex items-center justify-center text-3xl sm:text-4xl font-black text-blue-400 font-mono">0</div>
                        </div>

                        <h4 id="mWinnerName" class="text-lg sm:text-2xl font-black text-white uppercase tracking-wide">
                            SIAP MEMULAI
                        </h4>
                    </div>

                    <!-- Multi-Winner Preview Grid (Visible when drawCount > 1) -->
                    <div id="multiPreviewContainer" class="hidden bg-slate-950/90 border border-slate-800 rounded-2xl p-4 mb-6">
                        <p id="multiPreviewTitle" class="text-xs font-bold text-amber-400 uppercase tracking-wider mb-3">Preview 10 Pemenang Sekaligus</p>
                        <div id="multiPreviewGrid" class="grid grid-cols-2 sm:grid-cols-5 gap-2.5">
                            <!-- Dynamic preview slots -->
                        </div>
                    </div>

                    <!-- GIANT TRIGGER BUTTONS -->
                    <div class="flex justify-center gap-4">
                        <button id="btnStart" onclick="startSpin()" class="w-full sm:w-auto bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-600 hover:from-blue-500 hover:to-indigo-500 text-white text-lg sm:text-xl font-black py-4 px-12 rounded-2xl shadow-xl shadow-blue-900/40 transform transition-all duration-200 hover:scale-105 active:scale-95 flex items-center justify-center gap-3">
                            <svg class="w-6 h-6 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            <span id="btnStartLabel">PUTAR UNDIAN (3 DETIK)</span>
                        </button>

                        <button id="btnStop" onclick="stopSpin()" class="hidden w-full sm:w-auto bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 text-white text-lg sm:text-xl font-black py-4 px-14 rounded-2xl shadow-xl shadow-red-900/40 transform transition-all duration-200 hover:scale-105 active:scale-95 flex items-center justify-center gap-3">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8 7a1 1 0 00-1 1v4a1 1 0 001 1h4a1 1 0 001-1V8a1 1 0 00-1-1H8z" clip-rule="evenodd"></path></svg>
                            <span id="btnStopLabel">STOP (3s)</span>
                        </button>
                    </div>

                    <p class="text-[11px] text-slate-400 mt-4">
                        ⏱️ <strong class="text-blue-400">Otomatis 3 Detik:</strong> Undian akan berputar selama 3 detik lalu otomatis berhenti (atau tekan <kbd class="px-2 py-0.5 bg-slate-800 border border-slate-700 rounded text-slate-300 font-mono text-xs">SPASI</kbd>).
                    </p>
                </div>

            </div>

            <!-- RIGHT COLUMN: DAFTAR PEMENANG & LOG (5 COLS) -->
            <div class="lg:col-span-5 flex flex-col space-y-6">

                <div class="bg-slate-900/80 border border-slate-800 rounded-3xl p-5 sm:p-6 shadow-xl backdrop-blur-md flex-grow flex flex-col">
                    
                    <div class="flex justify-between items-center pb-4 border-b border-slate-800 mb-4">
                        <div>
                            <h3 class="text-sm font-black text-white flex items-center gap-2">
                                <span>🏆</span> DAFTAR PEMENANG TERPILIH
                            </h3>
                            <p class="text-[11px] text-slate-400 mt-0.5">Otomatis tidak akan terundi dua kali</p>
                        </div>

                        <div class="flex items-center gap-2">
                            <button onclick="exportWinnersExcel()" class="bg-emerald-950/80 hover:bg-emerald-900 text-emerald-300 text-xs font-bold py-1.5 px-3 rounded-xl border border-emerald-700/60 shadow-md transition flex items-center gap-1.5" title="Download Data Pemenang format Excel (.csv)">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <span>Export Excel</span>
                            </button>
                            <button onclick="printWinners()" class="bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold py-1.5 px-2.5 rounded-xl border border-slate-700 transition" title="Cetak / Print PDF">
                                🖨️
                            </button>
                            <button onclick="resetWinners()" class="bg-rose-950/60 hover:bg-rose-900 text-rose-300 text-xs font-bold py-1.5 px-2.5 rounded-xl border border-rose-800 transition" title="Reset Sesi Ini">
                                🗑️
                            </button>
                        </div>
                    </div>

                    <!-- Winners Scrollable List -->
                    <div class="overflow-y-auto max-h-[580px] custom-scrollbar flex-grow space-y-3" id="winnersListContainer">
                        
                        <div id="emptyWinnersNotice" class="text-center py-16 text-slate-500 text-xs">
                            <p class="text-2xl mb-2">🎁</p>
                            Belum ada pemenang yang terundi pada sesi ini.
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-slate-950 border-t border-slate-900 py-3 text-center text-xs text-slate-600">
        MRP Fun Run 2026 Kabupaten Jeneponto • Panel Operator Doorprize
    </footer>

    <!-- OPERATOR ENGINE & DUAL-SCREEN SYNC -->
    <script>
        let rawParticipants = @json($eligibleParticipants);
        let activePool = [];
        let wonParticipantIds = [];
        let winnersHistory = [];
        
        let spinInterval = null;
        let isSpinning = false;
        let stageConnected = false;

        // BROADCAST CHANNEL SYNC
        const channel = new BroadcastChannel('mrp_doorprize_channel');

        function broadcast(data) {
            channel.postMessage(data);
            // Fallback via localStorage
            localStorage.setItem('mrp_doorprize_event', JSON.stringify({
                ...data,
                _timestamp: Date.now()
            }));
        }

        channel.onmessage = (event) => {
            if (event.data) {
                if (event.data.type === 'STAGE_READY') {
                    setStageConnected(true);
                    // Sync current prize and draw count to Stage immediately
                    broadcast({
                        type: 'SET_PRIZE',
                        prizeName: document.getElementById('prizeNameInput').value.trim(),
                        drawCount: parseInt(document.getElementById('drawCountSelect').value) || 1
                    });
                } else if (event.data.type === 'TOGGLE_SPIN') {
                    if (isSpinning) {
                        stopSpin();
                    } else {
                        startSpin();
                    }
                }
            }
        };

        function setStageConnected(status) {
            stageConnected = status;
            const badge = document.getElementById('stageStatusBadge');
            const dot = document.getElementById('stageDot');
            const text = document.getElementById('stageText');
            const miniDot = document.getElementById('miniConnDot');

            if (status) {
                badge.className = "bg-emerald-950/80 text-emerald-300 border border-emerald-500/50 text-xs px-3.5 py-1.5 rounded-xl font-bold flex items-center gap-2";
                dot.className = "w-2 h-2 rounded-full bg-emerald-400 animate-pulse";
                text.innerText = "Layar Panggung Terhubung";
                miniDot.className = "w-2.5 h-2.5 rounded-full bg-emerald-400";
            } else {
                badge.className = "bg-amber-950/70 text-amber-300 border border-amber-600/50 text-xs px-3.5 py-1.5 rounded-xl font-bold flex items-center gap-2";
                dot.className = "w-2 h-2 rounded-full bg-amber-400";
                text.innerText = "Layar Panggung Belum Dibuka";
                miniDot.className = "w-2.5 h-2.5 rounded-full bg-amber-400";
            }
        }

        function openStageWindow() {
            window.open("{{ route('admin.doorprize.stage') }}", "MRP_STAGE_SCREEN", "width=1280,height=800,menubar=no,toolbar=no,location=no,status=no");
            setStageConnected(true);
        }

        function setPresetPrize(name, count = 1) {
            document.getElementById('prizeNameInput').value = name;
            document.getElementById('drawCountSelect').value = count;
            onDrawCountChange();
            broadcast({
                type: 'SET_PRIZE',
                prizeName: name,
                drawCount: count
            });
        }

        function onDrawCountChange() {
            const count = parseInt(document.getElementById('drawCountSelect').value) || 1;
            const singleBox = document.getElementById('singlePreviewContainer');
            const multiBox = document.getElementById('multiPreviewContainer');
            const grid = document.getElementById('multiPreviewGrid');
            const title = document.getElementById('multiPreviewTitle');

            if (count === 1) {
                singleBox.classList.remove('hidden');
                multiBox.classList.add('hidden');
            } else {
                singleBox.classList.add('hidden');
                multiBox.classList.remove('hidden');
                title.innerText = `Preview ${count} Pemenang Sekaligus`;

                grid.innerHTML = '';
                for (let i = 1; i <= count; i++) {
                    grid.innerHTML += `
                        <div id="mSlot${i}" class="bg-slate-900 border border-slate-800 rounded-xl p-2.5 text-center">
                            <span class="text-[10px] font-bold text-slate-400 uppercase">#${i}</span>
                            <div id="mSlotBib${i}" class="text-xl font-black text-blue-400 font-mono my-0.5">0000</div>
                            <div id="mSlotName${i}" class="text-xs font-bold text-white truncate">SIAP</div>
                        </div>
                    `;
                }
            }

            broadcast({
                type: 'SET_DRAW_COUNT',
                drawCount: count
            });
        }

        document.getElementById('prizeNameInput').addEventListener('input', function() {
            broadcast({
                type: 'SET_PRIZE',
                prizeName: this.value.trim(),
                drawCount: parseInt(document.getElementById('drawCountSelect').value) || 1
            });
        });

        function maskPhone(phone) {
            if (!phone) return '-';
            let str = String(phone).trim();
            if (str.length <= 6) return str;
            let start = str.substring(0, 4);
            let end = str.substring(str.length - 3);
            return start + '-****-' + end;
        }

        function applyFilter() {
            const selectedCat = document.getElementById('categoryFilter').value;
            activePool = rawParticipants.filter(p => {
                if (wonParticipantIds.includes(p.id)) return false;
                
                if (selectedCat === 'ALL') return true;
                if (selectedCat === '5K') return p.ticket_category && p.ticket_category.includes('5K') && !p.ticket_category.includes('Finisher');
                if (selectedCat === '10K') return p.ticket_category && p.ticket_category.includes('10K') && !p.ticket_category.includes('Finisher');
                if (selectedCat === 'FINISHER') return p.ticket_category && p.ticket_category.includes('Finisher');
                return true;
            });

            document.getElementById('poolCountText').innerText = activePool.length;
        }

        async function refreshData() {
            try {
                const res = await fetch("{{ route('admin.doorprize.data') }}");
                const data = await res.json();
                if (data.status === 'success') {
                    rawParticipants = data.participants;
                    applyFilter();
                    alert("Sinkronisasi berhasil! Total peserta siap undi: " + data.total + " orang.");
                }
            } catch (err) {
                alert("Gagal sinkronisasi data dari server.");
            }
        }

        let autoStopTimeout = null;
        let countdownInterval = null;
        const SPIN_DURATION_SECONDS = 3; // Durasi roll undian 3 detik

        function updateMiniDigits(bibNumber) {
            const str = String(bibNumber).padStart(4, '0');
            for(let i=1; i<=4; i++) {
                document.getElementById('mDigit' + i).innerText = str[i-1];
            }
        }

        function startSpin() {
            if (isSpinning) return;
            applyFilter();

            const drawCount = parseInt(document.getElementById('drawCountSelect').value) || 1;

            if (activePool.length === 0) {
                alert("Tidak ada peserta yang memenuhi syarat di kategori ini (atau semua sudah menang)!");
                return;
            }

            if (activePool.length < drawCount) {
                alert(`Peserta siap undi hanya sisa ${activePool.length} orang, tidak cukup untuk undi ${drawCount} pemenang sekaligus.`);
                return;
            }

            isSpinning = true;
            const currentPrize = document.getElementById('prizeNameInput').value.trim() || 'Hadiah Doorprize';

            document.getElementById('btnStart').classList.add('hidden');
            document.getElementById('btnStop').classList.remove('hidden');

            let secondsLeft = SPIN_DURATION_SECONDS;
            const stopLabelEl = document.getElementById('btnStopLabel');
            if (stopLabelEl) stopLabelEl.innerText = `STOP (${secondsLeft}s)`;

            // Send to Stage
            broadcast({
                type: 'START_SPIN',
                pool: activePool,
                prizeName: currentPrize,
                drawCount: drawCount,
                duration: SPIN_DURATION_SECONDS
            });

            if (spinInterval) clearInterval(spinInterval);
            spinInterval = setInterval(() => {
                if (drawCount === 1) {
                    const randomIndex = Math.floor(Math.random() * activePool.length);
                    const p = activePool[randomIndex];
                    updateMiniDigits(p.bib_number);
                    document.getElementById('mWinnerName').innerText = p.full_name;
                } else {
                    for (let i = 1; i <= drawCount; i++) {
                        const randomIndex = Math.floor(Math.random() * activePool.length);
                        const p = activePool[randomIndex];
                        const bibEl = document.getElementById('mSlotBib' + i);
                        const nameEl = document.getElementById('mSlotName' + i);
                        if (bibEl) bibEl.innerText = String(p.bib_number).padStart(4, '0');
                        if (nameEl) nameEl.innerText = p.full_name;
                    }
                }
            }, 60);

            // Hitung mundur visual di tombol Stop
            if (countdownInterval) clearInterval(countdownInterval);
            countdownInterval = setInterval(() => {
                secondsLeft--;
                if (secondsLeft > 0) {
                    if (stopLabelEl) stopLabelEl.innerText = `STOP (${secondsLeft}s)`;
                } else {
                    clearInterval(countdownInterval);
                }
            }, 1000);

            // OTOMATIS BERHENTI TEPAT SETELAH 3 DETIK
            if (autoStopTimeout) clearTimeout(autoStopTimeout);
            autoStopTimeout = setTimeout(() => {
                stopSpin();
            }, SPIN_DURATION_SECONDS * 1000);
        }

        function stopSpin() {
            if (!isSpinning) return;
            if (spinInterval) clearInterval(spinInterval);
            if (autoStopTimeout) clearTimeout(autoStopTimeout);
            if (countdownInterval) clearInterval(countdownInterval);
            isSpinning = false;

            document.getElementById('btnStop').classList.add('hidden');
            document.getElementById('btnStart').classList.remove('hidden');
            const stopLabelEl = document.getElementById('btnStopLabel');
            if (stopLabelEl) stopLabelEl.innerText = `STOP (3s)`;

            const drawCount = parseInt(document.getElementById('drawCountSelect').value) || 1;
            const currentPrize = document.getElementById('prizeNameInput').value.trim() || 'Hadiah Doorprize';

            // Ambil N pemenang unik
            const winners = [];
            const pUpper = currentPrize.toUpperCase();

            // Daftar seluruh BIB yang diproteksi hanya untuk hadiah utamanya masing-masing
            const allSpecialBibs = ['1575', '1373', '0244', '1542', '0878', '1576', '244', '878'];

            // Alokasi pemenang terarah untuk hadiah khusus
            let targetBibs = null;
            if (pUpper.includes('HP') || pUpper.includes('SMARTPHONE') || pUpper.includes('HANDPHONE') || pUpper.includes('DEDI') || pUpper.includes('TAWANG')) {
                targetBibs = ['1575', '1373', '0244', '1542'];
            } else if (pUpper.includes('TV') || pUpper.includes('TELEVISI') || pUpper.includes('AMOR') || pUpper.includes('SMART TV')) {
                targetBibs = ['0878'];
            } else if (pUpper.includes('MESIN CUCI') || pUpper.includes('WASHING') || pUpper.includes('CUCI')) {
                targetBibs = ['1576'];
            }

            // Proteksi: Jika sedang undi hadiah reguler lain (Setrika, TWS, Kipas, dll),
            // kecualikan BIB khusus agar tidak keluar/menang di hadiah lain
            let tempPool = activePool.filter(p => {
                if (targetBibs) return true; // Jika undi hadiah target, izinkan
                const pNorm = String(parseInt(p.bib_number, 10));
                const pPad = String(p.bib_number).trim().padStart(4, '0');
                const pRaw = String(p.bib_number).trim();
                return !allSpecialBibs.includes(pNorm) && !allSpecialBibs.includes(pPad) && !allSpecialBibs.includes(pRaw);
            });

            if (targetBibs && targetBibs.length > 0) {
                targetBibs.forEach(bib => {
                    const normBib = String(parseInt(bib, 10));
                    const padBib = bib.padStart(4, '0');

                    // 1. Cek di tempPool
                    let foundIdx = tempPool.findIndex(p => {
                        const pNorm = String(parseInt(p.bib_number, 10));
                        const pPad = String(p.bib_number).trim().padStart(4, '0');
                        return pNorm === normBib || pPad === padBib || String(p.bib_number).trim() === bib;
                    });

                    if (foundIdx !== -1) {
                        const winner = tempPool.splice(foundIdx, 1)[0];
                        if (!winners.some(w => w.id === winner.id)) {
                            winners.push(winner);
                        }
                    } else {
                        // 2. Cek di seluruh rawParticipants
                        let fallback = rawParticipants.find(p => {
                            const pNorm = String(parseInt(p.bib_number, 10));
                            const pPad = String(p.bib_number).trim().padStart(4, '0');
                            return pNorm === normBib || pPad === padBib || String(p.bib_number).trim() === bib;
                        });

                        if (fallback && !winners.some(w => w.id === fallback.id)) {
                            winners.push(fallback);
                        }
                    }
                });
            }

            // Lengkapi sisa slot jika belum mencukupi atau jika hadiah reguler
            while (winners.length < drawCount && tempPool.length > 0) {
                const randIdx = Math.floor(Math.random() * tempPool.length);
                const winner = tempPool.splice(randIdx, 1)[0];
                if (!winners.some(w => w.id === winner.id)) {
                    winners.push(winner);
                }
            }

            if (drawCount === 1 && winners[0]) {
                updateMiniDigits(winners[0].bib_number);
                document.getElementById('mWinnerName').innerText = winners[0].full_name;
            } else {
                winners.forEach((w, idx) => {
                    const slotNum = idx + 1;
                    const bibEl = document.getElementById('mSlotBib' + slotNum);
                    const nameEl = document.getElementById('mSlotName' + slotNum);
                    if (bibEl) {
                        bibEl.innerText = String(w.bib_number).padStart(4, '0');
                        bibEl.className = "text-xl font-black text-amber-400 font-mono my-0.5";
                    }
                    if (nameEl) nameEl.innerText = w.full_name;
                });
            }

            // Broadcast to Stage Screen
            broadcast({
                type: 'STOP_SPIN',
                winners: winners,
                prizeName: currentPrize,
                drawCount: drawCount
            });

            // Record All Winners in History
            winners.forEach(w => {
                recordWinner(w, currentPrize);
            });

            applyFilter();
        }

        const STORAGE_KEY_WINNERS = 'mrp_doorprize_winners_history';

        function loadWinnersFromStorage() {
            try {
                const saved = localStorage.getItem(STORAGE_KEY_WINNERS);
                if (saved) {
                    winnersHistory = JSON.parse(saved) || [];
                    wonParticipantIds = winnersHistory.map(w => w.id);
                }
            } catch(e) {
                winnersHistory = [];
                wonParticipantIds = [];
            }
        }

        function saveWinnersToStorage() {
            try {
                localStorage.setItem(STORAGE_KEY_WINNERS, JSON.stringify(winnersHistory));
            } catch(e) {}
        }

        function recordWinner(winner, prizeName) {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });

            const winnerRecord = {
                id: winner.id,
                bib_number: winner.bib_number,
                full_name: winner.full_name,
                ticket_category: winner.ticket_category,
                community: winner.community || '-',
                whatsapp: winner.whatsapp,
                prize: prizeName,
                time: timeStr
            };

            wonParticipantIds.push(winner.id);
            winnersHistory.unshift(winnerRecord);
            saveWinnersToStorage();
            renderWinnersList();
        }

        function renderWinnersList() {
            const container = document.getElementById('winnersListContainer');
            if (!winnersHistory || winnersHistory.length === 0) {
                container.innerHTML = `
                    <div id="emptyWinnersNotice" class="text-center py-16 text-slate-500 text-xs">
                        <p class="text-2xl mb-2">🎁</p>
                        Belum ada pemenang yang terundi pada sesi ini.
                    </div>
                `;
                return;
            }

            let html = '';
            winnersHistory.forEach((w, index) => {
                const bibFormatted = String(w.bib_number).padStart(4, '0');
                html += `
                    <div class="bg-slate-950 border border-slate-800 rounded-2xl p-4 flex items-center justify-between gap-3 hover:border-slate-700 transition">
                        <div class="flex items-center gap-3">
                            <div class="bg-blue-900/60 text-blue-300 font-mono font-black text-lg px-3 py-1.5 rounded-xl border border-blue-500/40 text-center min-w-[65px]">
                                ${bibFormatted}
                            </div>
                            <div>
                                <p class="font-black text-white text-sm uppercase">${w.full_name}</p>
                                <p class="text-xs font-bold text-amber-400">🎁 ${w.prize}</p>
                                <p class="text-[11px] text-slate-400 font-mono mt-0.5">
                                    ${w.ticket_category} ${w.community !== '-' ? '• ' + w.community : ''} • 📞 ${maskPhone(w.whatsapp)}
                                </p>
                            </div>
                        </div>
                        <div class="text-right flex flex-col items-end gap-1.5">
                            <span class="text-[10px] text-slate-500 font-mono">${w.time}</span>
                            <button onclick="disqualifyWinner(${w.id})" class="bg-rose-950/80 hover:bg-rose-900 text-rose-300 text-[11px] font-bold px-2.5 py-1 rounded-lg border border-rose-800 transition" title="Diskualifikasi jika tidak hadir">
                                ❌ Undi Ulang
                            </button>
                        </div>
                    </div>
                `;
            });
            container.innerHTML = html;
        }

        function disqualifyWinner(participantId) {
            if (!confirm("Diskualifikasi pemenang ini dan masukkan kembali ke dalam undian (undi ulang)?")) return;
            wonParticipantIds = wonParticipantIds.filter(id => id !== participantId);
            winnersHistory = winnersHistory.filter(w => w.id !== participantId);
            saveWinnersToStorage();
            renderWinnersList();
            applyFilter();

            broadcast({
                type: 'RESET'
            });
        }

        function resetWinners() {
            if (!confirm("PERINGATAN! Anda yakin ingin mereset seluruh daftar pemenang sesi ini?")) return;
            wonParticipantIds = [];
            winnersHistory = [];
            localStorage.removeItem(STORAGE_KEY_WINNERS);
            renderWinnersList();
            applyFilter();

            broadcast({
                type: 'RESET'
            });
        }

        function exportWinnersExcel() {
            if (!winnersHistory || winnersHistory.length === 0) {
                alert("Belum ada data pemenang yang terundi untuk di-download ke Excel.");
                return;
            }

            // CSV Content with UTF-8 BOM so Excel opens with proper encoding
            let csvContent = "\uFEFF";
            csvContent += "No,Nomor BIB,Nama Lengkap,Hadiah,Kategori Lari,Komunitas,No WhatsApp,Waktu Terundi\n";

            winnersHistory.forEach((w, idx) => {
                const no = idx + 1;
                const bib = '="' + String(w.bib_number).padStart(4, '0') + '"';
                const name = '"' + (w.full_name || '').replace(/"/g, '""') + '"';
                const prize = '"' + (w.prize || '').replace(/"/g, '""') + '"';
                const cat = '"' + (w.ticket_category || '').replace(/"/g, '""') + '"';
                const comm = '"' + (w.community || '-').replace(/"/g, '""') + '"';
                const wa = '="' + String(w.whatsapp || '').trim() + '"';
                const time = '"' + (w.time || '') + '"';

                csvContent += `${no},${bib},${name},${prize},${cat},${comm},${wa},${time}\n`;
            });

            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            const now = new Date();
            const dateStr = now.toISOString().slice(0, 10);
            link.setAttribute('href', url);
            link.setAttribute('download', `Rekap_Pemenang_Doorprize_MRP_Run_2026_${dateStr}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        function printWinners() {
            window.print();
        }

        // Spacebar shortcut
        document.addEventListener('keydown', function(e) {
            if (e.code === 'Space' && e.target.tagName !== 'INPUT' && e.target.tagName !== 'SELECT') {
                e.preventDefault();
                if (isSpinning) {
                    stopSpin();
                } else {
                    startSpin();
                }
            }
        });

        // Initialize from local storage on page load
        loadWinnersFromStorage();
        renderWinnersList();
        applyFilter();
        onDrawCountChange();
    </script>
</body>
</html>
