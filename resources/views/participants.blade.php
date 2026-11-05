<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participant List 2026 - MRP Fun Run</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-800 font-sans antialiased min-h-screen pb-12">

    <div class="max-w-5xl mx-auto px-4 pt-6">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-blue-600 font-semibold text-sm transition flex items-center">
            &larr; Kembali ke Beranda
        </a>
    </div>

    <div class="max-w-5xl mx-auto px-4 py-8">
        
        <div class="text-center mb-10">
            <h1 class="text-4xl md:text-5xl font-black text-[#d9534f] tracking-wide mb-4">Participant List 2026</h1>
            <div class="flex justify-center items-center">
                <div class="h-px bg-gray-200 w-16"></div>
                <div class="w-2 h-2 bg-gray-300 rounded-full mx-2"></div>
                <div class="h-px bg-gray-200 w-16"></div>
            </div>
        </div>

        <form action="{{ route('participants.list') }}" method="GET" class="flex flex-col sm:flex-row gap-4 mb-6">
            <div class="w-full sm:w-64">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Find Participants" class="w-full px-4 py-2 border border-gray-300 rounded focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none text-sm text-gray-700">
            </div>
            <div class="w-full sm:w-64">
                <select name="category" onchange="this.form.submit()" class="w-full px-4 py-2 border border-gray-300 rounded focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none text-sm text-gray-700 bg-white">
                    <option value="">All Category</option>
                    <option value="5K" {{ request('category') == '5K' ? 'selected' : '' }}>5K REGULAR</option>
                    <option value="10K" {{ request('category') == '10K' ? 'selected' : '' }}>10K REGULAR</option>
                    <option value="Finisher Package 5K" {{ request('category') == 'Finisher Package 5K' ? 'selected' : '' }}>FINISHER PACKAGE 5K</option>
                    <option value="Finisher Package 10K" {{ request('category') == 'Finisher Package 10K' ? 'selected' : '' }}>FINISHER PACKAGE 10K</option>
                </select>
            </div>
            <button type="submit" class="hidden">Search</button>
        </form>

        <div class="overflow-x-auto border border-gray-300 rounded-sm">
            <table class="w-full text-center border-collapse">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 text-sm">
                        <th class="py-3 px-4 font-semibold border-b border-gray-300">BIB No</th>
                        <th class="py-3 px-4 font-semibold border-b border-gray-300">BIB Name</th>
                        <th class="py-3 px-4 font-semibold border-b border-gray-300">Name</th>
                        <th class="py-3 px-4 font-semibold border-b border-gray-300">Category</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    @forelse($participants as $index => $p)
                        <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-gray-100 transition border-b border-gray-200 last:border-0">
                            <td class="py-3 px-4 font-black text-gray-900">{{ $p->bib_number ? sprintf('%04d', $p->bib_number) : '-' }}</td>
                            <td class="py-3 px-4 font-medium text-gray-800 uppercase">{{ $p->bib_name }}</td>
                            <td class="py-3 px-4 font-medium text-gray-800 uppercase">{{ $p->full_name }}</td>
                            <td class="py-3 px-4 font-semibold uppercase">{{ str_contains(strtoupper($p->ticket_category), 'FINISHER') ? $p->ticket_category : $p->ticket_category . ' REGULAR' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-gray-500 italic bg-white">
                                Tidak ada data peserta ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <p class="text-xs text-gray-400 mt-4 text-center">
            *Hanya menampilkan peserta yang pendaftarannya telah diverifikasi (Lunas).
        </p>

    </div>
</body>
</html>