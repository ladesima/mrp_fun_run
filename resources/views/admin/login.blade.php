<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - MRP Run 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen bg-gradient-to-br from-blue-950 via-gray-900 to-black font-sans antialiased">
    
    <div class="hidden lg:flex w-1/2 items-center justify-center p-12 bg-black/20 backdrop-blur-sm border-r border-gray-800">
        <div class="text-center space-y-6">
            <img src="{{ asset('images/MRP.jpeg') }}" alt="MRP Run 2026" class="max-w-xs h-auto mx-auto drop-shadow-2xl rounded-2xl">
            <h2 class="text-3xl font-black text-white tracking-widest uppercase mt-6">MRP FUN RUN 2026</h2>
            <p class="text-gray-400 text-sm max-w-sm mx-auto">Sistem Informasi Manajemen Pendaftaran dan Validasi Tiket Peserta.</p>
        </div>
    </div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 relative">
        <a href="{{ route('home') }}" class="absolute top-8 right-8 text-gray-500 hover:text-white transition text-sm flex items-center">
            Kembali ke Web &rarr;
        </a>

        <div class="w-full max-w-md bg-white p-10 rounded-3xl shadow-2xl border border-gray-100">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-wide uppercase">Admin Sign In</h2>
                <p class="text-sm text-gray-500 mt-2">Silakan masuk menggunakan kredensial Anda</p>
            </div>
            
            @error('name')
                <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm mb-6 font-semibold border border-red-100 text-center">
                    {{ $message }}
                </div>
            @enderror
            
            <form action="{{ route('admin.login.process') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Username</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Masukkan nama admin..." class="w-full px-5 py-4 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" required placeholder="Masukkan password..." class="w-full px-5 py-4 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
                
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-xl shadow-lg hover:shadow-xl transform transition hover:-translate-y-1 text-lg uppercase tracking-wider mt-4">
                    Masuk ke Dashboard
                </button>
            </form>
        </div>
    </div>

</body>
</html>