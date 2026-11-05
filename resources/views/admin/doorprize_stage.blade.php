<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layar Panggung Doorprize - MRP Fun Run 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>
    <style>
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 35px rgba(59, 130, 246, 0.6), inset 0 0 20px rgba(59, 130, 246, 0.4); }
            50% { box-shadow: 0 0 65px rgba(59, 130, 246, 0.9), inset 0 0 35px rgba(59, 130, 246, 0.7); }
        }
        @keyframes gold-glow {
            0%, 100% { box-shadow: 0 0 45px rgba(234, 179, 8, 0.8), inset 0 0 25px rgba(234, 179, 8, 0.5); }
            50% { box-shadow: 0 0 90px rgba(234, 179, 8, 1), inset 0 0 45px rgba(234, 179, 8, 0.8); }
        }
        .animate-glow { animation: pulse-glow 2s infinite ease-in-out; }
        .animate-gold { animation: gold-glow 1.2s infinite ease-in-out; }
        .digit-box {
            background: linear-gradient(180deg, #1e293b 0%, #090d16 100%);
            border: 3px solid rgba(59, 130, 246, 0.6);
            text-shadow: 0 0 30px rgba(59, 130, 246, 0.9);
        }
        .gold-digit-box {
            background: linear-gradient(180deg, #362503 0%, #150f02 100%);
            border: 3px solid rgba(234, 179, 8, 0.8);
            text-shadow: 0 0 35px rgba(234, 179, 8, 1);
            color: #fbbf24 !important;
        }
        .multi-card {
            background: linear-gradient(180deg, rgba(30, 41, 59, 0.9) 0%, rgba(15, 23, 42, 0.95) 100%);
            border: 2px solid rgba(59, 130, 246, 0.4);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
            transition: all 0.4s ease;
        }
        .multi-card-gold {
            background: linear-gradient(180deg, rgba(54, 37, 3, 0.95) 0%, rgba(21, 15, 2, 0.98) 100%) !important;
            border: 2px solid rgba(234, 179, 8, 0.9) !important;
            box-shadow: 0 0 30px rgba(234, 179, 8, 0.6), inset 0 0 15px rgba(234, 179, 8, 0.3) !important;
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased min-h-screen flex flex-col justify-between selection:bg-blue-600 selection:text-white overflow-x-hidden select-none" ondblclick="toggleFullscreen()">

    <!-- Stage Header (Branding) -->
    <header class="py-4 px-8 flex justify-between items-center z-20">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white font-black shadow-lg shadow-blue-500/40 text-xl">
                🏃
            </div>
            <div>
                <h2 class="text-xl sm:text-2xl font-black tracking-wider uppercase text-white drop-shadow">
                    MRP FUN RUN 2026
                </h2>
                <p class="text-xs text-blue-400 font-bold uppercase tracking-widest">
                    Kabupaten Jeneponto
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <span id="connBadge" class="bg-emerald-950/80 border border-emerald-500/40 text-emerald-400 text-xs px-4 py-1.5 rounded-full font-bold uppercase tracking-wider flex items-center gap-2 backdrop-blur-md">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Layar Panggung Siap</span>
            </span>

            <button onclick="toggleFullscreen()" class="bg-slate-900/80 hover:bg-slate-800 text-slate-400 hover:text-white p-2 rounded-xl border border-slate-800 transition" title="Layar Penuh (F11 / Double Click)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-5h-4m4 0v4m0 0l-5-5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path></svg>
            </button>
        </div>
    </header>

    <!-- Main Stage Center Arena -->
    <main class="flex-grow flex flex-col items-center justify-center px-4 sm:px-8 py-2 relative z-10 w-full max-w-7xl mx-auto">
        
        <!-- Ambient Stage Glows -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[500px] bg-blue-600/15 rounded-full blur-[140px] pointer-events-none"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[400px] bg-purple-600/15 rounded-full blur-[120px] pointer-events-none"></div>

        <!-- Title & Prize Header -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600/20 via-purple-600/20 to-blue-600/20 border border-blue-500/40 px-6 py-1.5 rounded-full text-blue-300 text-xs sm:text-sm font-black uppercase tracking-widest mb-3 shadow-lg backdrop-blur-md">
                <span>🏆</span> PENGUNDIAN DOORPRIZE
            </div>

            <!-- CURRENT PRIZE NAME BANNER -->
            <div>
                <span id="stagePrizeLabel" class="inline-block bg-amber-500/20 border-2 border-amber-500/60 text-amber-300 text-xl sm:text-4xl font-black px-8 py-2.5 rounded-2xl uppercase tracking-wider shadow-xl shadow-amber-500/20 backdrop-blur-md transition-all">
                    🎁 HADIAH UTAMA
                </span>
            </div>
        </div>

        <!-- MODE 1: SINGLE WINNER STAGE DISPLAY -->
        <div id="stageSingleCard" class="bg-slate-900/90 border-2 border-blue-500/40 rounded-3xl p-8 sm:p-12 text-center shadow-2xl backdrop-blur-xl max-w-4xl w-full animate-glow transition-all duration-700">
            
            <p class="text-xs sm:text-sm font-black uppercase text-blue-400 tracking-widest mb-3">
                NOMOR BIB PESERTA
            </p>

            <div class="flex justify-center items-center gap-3 sm:gap-6 my-4">
                <div id="sDigit1" class="digit-box w-20 h-32 sm:w-36 sm:h-48 rounded-3xl flex items-center justify-center text-6xl sm:text-9xl font-black text-blue-400 font-mono shadow-2xl transition-all">0</div>
                <div id="sDigit2" class="digit-box w-20 h-32 sm:w-36 sm:h-48 rounded-3xl flex items-center justify-center text-6xl sm:text-9xl font-black text-blue-400 font-mono shadow-2xl transition-all">0</div>
                <div id="sDigit3" class="digit-box w-20 h-32 sm:w-36 sm:h-48 rounded-3xl flex items-center justify-center text-6xl sm:text-9xl font-black text-blue-400 font-mono shadow-2xl transition-all">0</div>
                <div id="sDigit4" class="digit-box w-20 h-32 sm:w-36 sm:h-48 rounded-3xl flex items-center justify-center text-6xl sm:text-9xl font-black text-blue-400 font-mono shadow-2xl transition-all">0</div>
            </div>

            <!-- PARTICIPANT NAME (CLEAN BIB + FULL NAME ONLY) -->
            <div class="min-h-[100px] flex flex-col items-center justify-center mt-4">
                <h1 id="sWinnerName" class="text-3xl sm:text-6xl font-black text-white uppercase tracking-wide transition-all drop-shadow-2xl">
                    MENUNGGU OPERATOR...
                </h1>
            </div>

        </div>

        <!-- MODE 2: MULTI-WINNER STAGE GRID (UP TO 10 SLOTS SIMULTANEOUSLY) -->
        <div id="stageMultiCard" class="hidden w-full max-w-6xl">
            <div id="stageMultiGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3 sm:gap-4">
                <!-- Dynamically generated slots -->
            </div>
        </div>

    </main>

    <!-- Stage Footer -->
    <footer class="py-3 text-center text-xs text-slate-500 z-20">
        MRP Fun Run 2026 Kabupaten Jeneponto • Double-click untuk Fullscreen
    </footer>

    <!-- STAGE BROADCAST LISTENER & ANIMATION ENGINE -->
    <script>
        let rawParticipants = @json($eligibleParticipants);
        let activePool = [];
        let wonParticipantIds = [];
        
        let spinInterval = null;
        let isSpinning = false;
        let soundEnabled = true;
        let currentDrawCount = 1;

        // Web Audio Synthesizer
        const AudioContext = window.AudioContext || window.webkitAudioContext;
        let audioCtx = null;

        function initAudio() {
            if (!audioCtx) {
                audioCtx = new AudioContext();
            }
            if (audioCtx.state === 'suspended') {
                audioCtx.resume();
            }
        }

        function playTickSound() {
            if (!soundEnabled) return;
            try {
                initAudio();
                const osc = audioCtx.createOscillator();
                const gain = audioCtx.createGain();
                osc.type = 'triangle';
                osc.frequency.setValueAtTime(450 + Math.random() * 200, audioCtx.currentTime);
                gain.gain.setValueAtTime(0.08, audioCtx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 0.04);
                osc.connect(gain);
                gain.connect(audioCtx.destination);
                osc.start();
                osc.stop(audioCtx.currentTime + 0.04);
            } catch(e) {}
        }

        function playWinSound() {
            if (!soundEnabled) return;
            try {
                initAudio();
                const now = audioCtx.currentTime;
                const notes = [261.63, 329.63, 392.00, 523.25, 659.25, 783.99];
                notes.forEach((freq, index) => {
                    const osc = audioCtx.createOscillator();
                    const gain = audioCtx.createGain();
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(freq, now + index * 0.08);
                    gain.gain.setValueAtTime(0.2, now + index * 0.08);
                    gain.gain.exponentialRampToValueAtTime(0.001, now + index * 0.08 + 0.6);
                    osc.connect(gain);
                    gain.connect(audioCtx.destination);
                    osc.start(now + index * 0.08);
                    osc.stop(now + index * 0.08 + 0.6);
                });
            } catch(e) {}
        }

        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(err => {});
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }

        function updateDigits(bibNumber, isGold = false) {
            const str = String(bibNumber).padStart(4, '0');
            for(let i=1; i<=4; i++) {
                const el = document.getElementById('sDigit' + i);
                if (el) {
                    el.innerText = str[i-1];
                    if (isGold) {
                        el.classList.add('gold-digit-box');
                    } else {
                        el.classList.remove('gold-digit-box');
                    }
                }
            }
        }

        function setPrizeLabel(name) {
            document.getElementById('stagePrizeLabel').innerText = '🎁 ' + (name ? name.toUpperCase() : 'HADIAH UTAMA');
        }

        function setupStageMode(drawCount) {
            currentDrawCount = drawCount;
            const singleCard = document.getElementById('stageSingleCard');
            const multiCard = document.getElementById('stageMultiCard');
            const grid = document.getElementById('stageMultiGrid');

            if (drawCount === 1) {
                singleCard.classList.remove('hidden');
                multiCard.classList.add('hidden');
            } else {
                singleCard.classList.add('hidden');
                multiCard.classList.remove('hidden');

                // Adjust grid columns based on count
                if (drawCount === 2) {
                    grid.className = "grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-3xl mx-auto";
                } else if (drawCount <= 4) {
                    grid.className = "grid grid-cols-2 sm:grid-cols-2 gap-4 max-w-4xl mx-auto";
                } else if (drawCount <= 6) {
                    grid.className = "grid grid-cols-2 sm:grid-cols-3 gap-4 max-w-5xl mx-auto";
                } else {
                    grid.className = "grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3 sm:gap-4 max-w-6xl mx-auto";
                }

                grid.innerHTML = '';
                for (let i = 1; i <= drawCount; i++) {
                    grid.innerHTML += `
                        <div id="stageSlot${i}" class="multi-card rounded-2xl p-4 sm:p-5 text-center flex flex-col justify-between">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-[11px] font-black uppercase text-blue-400 bg-blue-950/80 border border-blue-800 px-2 py-0.5 rounded-full">#${i}</span>
                                <span class="text-[10px] font-mono text-slate-400 uppercase tracking-widest">BIB</span>
                            </div>
                            <div id="stageSlotBib${i}" class="text-3xl sm:text-4xl font-black text-blue-400 font-mono tracking-wider my-2">0000</div>
                            <div id="stageSlotName${i}" class="text-sm sm:text-base font-black text-white uppercase tracking-wide truncate mt-1">SIAP UNDI</div>
                        </div>
                    `;
                }
            }
        }

        let stageAutoStopTimeout = null;

        function handleStartSpin(pool, prizeName, drawCount = 1) {
            activePool = pool && pool.length ? pool : rawParticipants;
            if (prizeName) setPrizeLabel(prizeName);

            setupStageMode(drawCount);
            isSpinning = true;
            initAudio();

            if (drawCount === 1) {
                const stageCard = document.getElementById('stageCard');
                if (stageCard) {
                    stageCard.classList.remove('animate-gold');
                    stageCard.classList.add('animate-glow');
                }
                updateDigits('0000', false);
                document.getElementById('sWinnerName').innerText = "MEMUTAR UNDIAN...";
            } else {
                for (let i = 1; i <= drawCount; i++) {
                    const slot = document.getElementById('stageSlot' + i);
                    if (slot) {
                        slot.classList.remove('multi-card-gold');
                    }
                }
            }

            if (spinInterval) clearInterval(spinInterval);
            spinInterval = setInterval(() => {
                if (drawCount === 1) {
                    const randomIndex = Math.floor(Math.random() * activePool.length);
                    const p = activePool[randomIndex];
                    updateDigits(p.bib_number, false);
                    document.getElementById('sWinnerName').innerText = p.full_name;
                } else {
                    for (let i = 1; i <= drawCount; i++) {
                        const randomIndex = Math.floor(Math.random() * activePool.length);
                        const p = activePool[randomIndex];
                        const bibEl = document.getElementById('stageSlotBib' + i);
                        const nameEl = document.getElementById('stageSlotName' + i);
                        if (bibEl) bibEl.innerText = String(p.bib_number).padStart(4, '0');
                        if (nameEl) nameEl.innerText = p.full_name;
                    }
                }
                playTickSound();
            }, 60);
        }

        function handleStopSpin(winners, prizeName, drawCount = 1) {
            if (spinInterval) clearInterval(spinInterval);
            if (stageAutoStopTimeout) clearTimeout(stageAutoStopTimeout);
            isSpinning = false;

            if (prizeName) setPrizeLabel(prizeName);

            const winnerList = Array.isArray(winners) ? winners : (winners ? [winners] : []);

            if (drawCount === 1 && winnerList[0]) {
                const w = winnerList[0];
                updateDigits(w.bib_number, true);
                document.getElementById('sWinnerName').innerText = w.full_name;

                const stageCard = document.getElementById('stageCard');
                if (stageCard) {
                    stageCard.classList.remove('animate-glow');
                    stageCard.classList.add('animate-gold');
                }
            } else if (drawCount > 1) {
                winnerList.forEach((w, idx) => {
                    const slotNum = idx + 1;
                    const slot = document.getElementById('stageSlot' + slotNum);
                    const bibEl = document.getElementById('stageSlotBib' + slotNum);
                    const nameEl = document.getElementById('stageSlotName' + slotNum);

                    if (slot) slot.classList.add('multi-card-gold');
                    if (bibEl) {
                        bibEl.innerText = String(w.bib_number).padStart(4, '0');
                        bibEl.classList.add('text-amber-300');
                    }
                    if (nameEl) nameEl.innerText = w.full_name;
                });
            }

            playWinSound();
            launchConfetti();
        }

        function launchConfetti() {
            const count = 300;
            const defaults = { origin: { y: 0.7 } };

            function fire(particleRatio, opts) {
                confetti(Object.assign({}, defaults, opts, {
                    particleCount: Math.floor(count * particleRatio)
                }));
            }

            fire(0.25, { spread: 30, startVelocity: 60 });
            fire(0.2, { spread: 70 });
            fire(0.35, { spread: 120, decay: 0.91, scalar: 1.1 });
            fire(0.1, { spread: 140, startVelocity: 30, decay: 0.92, scalar: 1.3 });
            fire(0.1, { spread: 140, startVelocity: 50 });
        }

        // ==========================================
        // REALTIME CROSS-TAB SYNC (BROADCAST CHANNEL + LOCALSTORAGE)
        // ==========================================
        const channel = new BroadcastChannel('mrp_doorprize_channel');

        function processMessage(msg) {
            if (!msg || !msg.type) return;

            if (msg.type === 'SET_PRIZE') {
                setPrizeLabel(msg.prizeName);
                if (msg.drawCount) setupStageMode(msg.drawCount);
            } else if (msg.type === 'SET_DRAW_COUNT') {
                setupStageMode(msg.drawCount);
            } else if (msg.type === 'START_SPIN') {
                handleStartSpin(msg.pool, msg.prizeName, msg.drawCount || 1);
            } else if (msg.type === 'STOP_SPIN') {
                handleStopSpin(msg.winners, msg.prizeName, msg.drawCount || 1);
            } else if (msg.type === 'RESET') {
                setupStageMode(1);
                updateDigits('0000', false);
                document.getElementById('sWinnerName').innerText = "SIAPKAN UNDIAN";
                const stageCard = document.getElementById('stageCard');
                if (stageCard) {
                    stageCard.classList.remove('animate-gold');
                    stageCard.classList.add('animate-glow');
                }
            }
        }

        channel.onmessage = (event) => {
            processMessage(event.data);
        };

        // Fallback via localStorage storage events
        window.addEventListener('storage', (event) => {
            if (event.key === 'mrp_doorprize_event' && event.newValue) {
                try {
                    const data = JSON.parse(event.newValue);
                    processMessage(data);
                } catch(e) {}
            }
        });

        // Spacebar shortcut from Stage screen
        document.addEventListener('keydown', function(e) {
            if (e.code === 'Space') {
                e.preventDefault();
                channel.postMessage({ type: 'TOGGLE_SPIN' });
            }
        });

        // Initialize Stage
        setupStageMode(1);

        // Notify Operator that Stage is active
        channel.postMessage({ type: 'STAGE_READY' });
    </script>
</body>
</html>
