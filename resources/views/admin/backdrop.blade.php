<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backdrop - {{ $current->full_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            overflow: hidden;
        }
    </style>
</head>

<body class="h-screen w-screen {{ str_contains($current->ticket_category, '10K') ? 'bg-gradient-to-br from-red-900 via-red-700 to-orange-500' : 'bg-gradient-to-br from-blue-900 via-blue-700 to-cyan-500' }} flex items-center justify-center relative overflow-hidden transition-colors duration-700">

    <a href="javascript:window.close();" class="absolute top-8 left-8 text-white/40 hover:text-white transition z-50 flex items-center gap-2" title="Tutup Layar">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        <span class="font-bold tracking-widest text-sm uppercase md:block hidden">Tutup</span>
    </a>

    @if($prev)
        <a href="{{ route('admin.racepack.backdrop', $prev->id) }}" class="absolute left-4 md:left-8 top-1/2 -translate-y-1/2 text-white/20 hover:text-white hover:scale-110 transition duration-300 z-50">
            <svg class="w-12 h-12 md:w-20 md:h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
    @endif

    @if($next)
        <a href="{{ route('admin.racepack.backdrop', $next->id) }}" class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 text-white/50 hover:text-white hover:scale-110 transition duration-300 z-50 animate-bounce" title="Lanjut ke peserta berikutnya">
            <svg class="w-12 h-12 md:w-20 md:h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>
    @else
        <div class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 text-white/30 flex flex-col items-center z-50">
            <svg class="w-8 h-8 md:w-12 md:h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <span class="text-[10px] md:text-xs font-bold text-center uppercase tracking-widest">Menunggu<br>Peserta</span>
        </div>
    @endif

    <div class="absolute top-0 left-0 w-96 h-96 bg-white/10 rounded-full blur-3xl"></div>
    
    <div class="absolute bottom-0 right-0 w-96 h-96 {{ str_contains($current->ticket_category, '10K') ? 'bg-orange-300/20' : 'bg-cyan-300/20' }} rounded-full blur-3xl"></div>

    <div class="relative z-10 w-full h-full flex flex-col justify-between py-6 md:py-10">
        
        <div class="h-2 md:h-8 w-full"></div>

        <div class="flex flex-col items-center justify-center text-center text-white px-4 md:px-10 flex-grow">
            
            <div class="mb-4 md:mb-8 flex flex-col items-center">
                <div class="flex items-center justify-center gap-4 md:gap-12 mb-2">
                    <img src="{{ asset('images/MRP.png') }}" alt="MRP Logo" class="w-28 md:w-64 object-contain drop-shadow-2xl bg-transparent">
                    <img src="{{ asset('images/logoresmi.png') }}" alt="Logo Resmi" class="w-28 md:w-64 object-contain drop-shadow-2xl bg-transparent">
                </div>
                <h1 class="text-5xl md:text-7xl font-black tracking-wider leading-none mt-1">
                    MRP FUN RUN
                </h1>
                <p class="text-base md:text-3xl font-bold mt-1 md:mt-3 {{ str_contains($current->ticket_category, '10K') ? 'text-red-100' : 'text-cyan-100' }} tracking-wide">
                    KABUPATEN JENEPONTO 2026
                </p>
            </div>

            <div class="mb-3 md:mb-6">
                <p class="text-xl md:text-4xl font-bold uppercase tracking-wide {{ str_contains($current->ticket_category, '10K') ? 'text-red-200' : 'text-cyan-200' }}">
                    SELAMAT DATANG PESERTA
                </p>
            </div>

            <div class="mb-4 md:mb-8 max-w-7xl px-2">
                <h2 class="text-5xl md:text-8xl font-black uppercase drop-shadow-2xl truncate">
                    {{ $current->bib_name ?: $current->full_name }}
                </h2>
            </div>

            <div class="mb-4 md:mb-8">
                <p class="text-lg md:text-3xl font-bold mb-2 md:mb-3">
                    NOMOR BIB :
                </p>
                <div class="{{ str_contains($current->ticket_category, '10K') ? 'text-red-900' : 'text-blue-900' }} bg-white px-10 md:px-16 py-3 md:py-6 rounded-2xl md:rounded-3xl shadow-2xl inline-block">
                    <span class="text-6xl md:text-9xl font-black tracking-widest">
                        {{ sprintf('%04d', $current->bib_number) }}
                    </span>
                </div>
            </div>

            <div class="mb-4 md:mb-8">
                <span class="{{ str_contains($current->ticket_category, '10K') ? 'bg-red-500/40 border border-red-400/50' : 'bg-white/20' }} backdrop-blur-lg px-6 md:px-8 py-2 md:py-4 rounded-full text-base md:text-3xl font-bold uppercase inline-block">
                    {{ str_contains(strtoupper($current->ticket_category), 'FINISHER') ? $current->ticket_category : $current->ticket_category . ' REGULAR' }}
                </span>
            </div>

            <div>
                <p class="text-sm md:text-2xl font-semibold tracking-wide {{ str_contains($current->ticket_category, '10K') ? 'text-red-100' : 'text-cyan-100' }} drop-shadow-md">
                    #BERLARIUNTUKSEHAT
                </p>
            </div>
        </div>

        <div class="w-full flex flex-col items-center justify-center pt-2 pb-4 md:pb-0 md:pt-4">
            <p class="text-[10px] md:text-sm font-bold {{ str_contains($current->ticket_category, '10K') ? 'text-red-200/80' : 'text-cyan-200/80' }} uppercase tracking-[0.3em] mb-3 md:mb-4">Sponsored By</p>
            <div class="flex items-center justify-center gap-4 md:gap-8 opacity-100 flex-wrap px-4">
                <img src="{{ asset('images/jepot.png') }}" alt="Sponsor Jepot" class="h-8 md:h-12 object-contain">
                <img src="{{ asset('images/bank.png') }}" alt="Sponsor Bank" class="h-8 md:h-12 object-contain">
                <img src="{{ asset('images/LAPAK.png') }}" alt="Sponsor Lapak Turatea" class="h-8 md:h-12 object-contain">
                <img src="{{ asset('images/Anugrahjaya2.png') }}" alt="Sponsor Anugrah Jaya" class="h-8 md:h-12 object-contain">
                <img src="{{ asset('images/PTfauziah.png') }}" alt="Sponsor fz" class="h-8 md:h-12 object-contain rounded-md">
                <img src="{{ asset('images/sponsorbru.png') }}" alt="Sponsor bru" class="h-12 md:h-16 object-contain">
                <img src="{{ asset('images/tecno.jpeg') }}" alt="Sponsor Tecno" class="h-8 md:h-12 object-contain rounded-md">
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('keydown', function(e) {
            @if($next) 
                if (e.key === 'ArrowRight' || e.key === ' ' || e.key === 'Enter') {
                    window.location.href = "{{ route('admin.racepack.backdrop', $next->id) }}"; 
                }
            @endif
            
            @if($prev) 
                if (e.key === 'ArrowLeft') {
                    window.location.href = "{{ route('admin.racepack.backdrop', $prev->id) }}"; 
                }
            @endif
        });
        
        @if(!$next)
            setInterval(() => { location.reload(); }, 5000);
        @endif
    </script>

</body>
</html>