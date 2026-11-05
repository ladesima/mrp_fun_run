<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RegistrationsExport;
use App\Exports\RacepackExport;

class AdminController extends Controller
{
    // Menampilkan halaman dashboard admin
    // UBAH FUNGSI INDEX MENJADI SEPERTI INI:
    public function index(\Illuminate\Http\Request $request)
    {
        // 1. Ambil data mentah untuk menghitung statistik secara cepat via database count
        $stats = [
            'total' => Registration::count(),
            '5k' => Registration::where('ticket_category', 'like', '5K%')->where('ticket_category', 'not like', '%Finisher%')->count(),
            '10k' => Registration::where('ticket_category', 'like', '10K%')->where('ticket_category', 'not like', '%Finisher%')->count(),
            'finisher' => Registration::where('ticket_category', 'like', '%Finisher%')->count(),
            'pending' => Registration::where('payment_status', 'pending')->whereNotNull('payment_proof')->count(),
        ];

        // 2. Mulai Query untuk Tabel (Agar bisa difilter)
        $query = Registration::query();

        // Filter Pencarian (Nama, Kode, atau WA)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('registration_code', 'like', "%{$search}%")
                  ->orWhere('whatsapp', 'like', "%{$search}%");
            });
        }

        // Filter Kategori
        if ($request->filled('category')) {
            $cat = $request->category;
            if ($cat === 'FINISHER') {
                $query->where('ticket_category', 'like', '%Finisher%');
            } else {
                $query->where('ticket_category', $cat);
            }
        }

        // Filter Status
        if ($request->filled('status')) {
            if ($request->status == 'paid') {
                $query->where('payment_status', 'paid');
            } elseif ($request->status == 'pending_proof') {
                $query->where('payment_status', 'pending')->whereNotNull('payment_proof');
            } elseif ($request->status == 'pending_no_proof') {
                $query->where('payment_status', 'pending')->whereNull('payment_proof');
            }
        }

        // Eksekusi query dengan paginasi 100 data per halaman
        $registrations = $query->latest()->paginate(100)->withQueryString();

        return view('admin.dashboard', compact('registrations', 'stats'));
    }
// Fungsi untuk mendownload data ke Excel
    public function exportExcel()
    {
        return Excel::download(new RegistrationsExport, 'Data_Peserta_MRP_2026.xlsx');
    }

    // TAMBAHKAN FUNGSI INI DI BAWAH FUNGSI verifyPayment:
    public function cancelVerify($id)
    {
        $registration = Registration::findOrFail($id);
        
        $registration->update([
            'payment_status' => 'pending'
        ]);

        return back()->with('success', 'Validasi pembayaran atas nama ' . $registration->full_name . ' berhasil dibatalkan.');
    }

    // Fungsi untuk memvalidasi pembayaran menjadi Lunas
    public function verifyPayment($id)
    {
        $registration = Registration::findOrFail($id);
        
        $bib = $registration->bib_number;
        
        // Buat nomor BIB urut otomatis JIKA belum punya
        if (!$bib) {
            // Cari nomor BIB terbesar/terakhir yang sudah pernah diberikan ke siapapun
            $lastReg = Registration::whereNotNull('bib_number')
                                ->orderBy('bib_number', 'desc')
                                ->first();
                                
            // Jika sudah ada peserta yang punya BIB, tambah 1. 
            // Jika ini peserta pertama yang divalidasi, mulai dari 11.
            $bib = $lastReg ? $lastReg->bib_number + 1 : 11;
        }

        // Simpan status Lunas beserta Nomor BIB-nya (disimpan sebagai angka 11, 12, dst)
        $registration->update([
            'payment_status' => 'paid',
            'bib_number' => $bib
        ]);

        // Format angka menjadi 4 digit (contoh: 11 menjadi 0011) khusus untuk pesan pop-up
        $formattedBib = sprintf('%04d', $bib);

        return back()->with('success', 'Validasi berhasil! Nomor BIB ' . $formattedBib . ' diberikan kepada ' . $registration->full_name);
    }
    // Tambahkan fungsi ini untuk menampilkan halaman detail
    public function show($id)
    {
        $registration = \App\Models\Registration::findOrFail($id);
        
        return view('admin.show', compact('registration'));
    }
    // Menampilkan halaman Pengambilan Racepack
    public function racepackIndex(\Illuminate\Http\Request $request)
    {
        // Jika akun adalah admin doorprize, arahkan ke halaman doorprize
        if (Auth::user() && Auth::user()->isDoorprizeAdmin()) {
            return redirect()->route('admin.doorprize');
        }

        $hasCollectorRel = method_exists(Registration::class, 'racepackCollector');

        // HANYA memanggil data yang sudah LUNAS (paid)
        $query = Registration::where('payment_status', 'paid');
        if ($hasCollectorRel) {
            $query->with('racepackCollector');
        }

        // Filter Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('registration_code', 'like', "%{$search}%")
                  ->orWhere('bib_number', 'like', "%{$search}%")
                  ->orWhere('identity_number', 'like', "%{$search}%");
            });
        }

        // Filter Status Pengambilan
        if ($request->filled('status')) {
            if ($request->status === 'collected') {
                $query->where('is_racepack_collected', true);
            } elseif ($request->status === 'uncollected') {
                $query->where('is_racepack_collected', false);
            }
        }

        // Filter Ukuran Jersey
        if ($request->filled('jersey_size')) {
            $query->where('jersey_size', $request->jersey_size);
        }

        // Filter Petugas Tertentu (Otomatis default ke user login jika akun adalah Petugas Racepack)
        $selectedCollector = '';
        if ($request->has('collector_id')) {
            $selectedCollector = $request->collector_id;
        } elseif (Auth::user() && Auth::user()->isRacepackAdmin()) {
            $selectedCollector = (string)Auth::id();
        }

        if (!empty($selectedCollector)) {
            $query->where('racepack_collected_by', $selectedCollector);
        }

        // Statistik Pengambilan Racepack
        $totalPaid = Registration::where('payment_status', 'paid')->count();
        $totalCollected = Registration::where('payment_status', 'paid')->where(function($q) {
            $q->where('is_racepack_collected', true)->orWhere('is_racepack_collected', 1);
        })->count();
        $totalUncollected = max(0, $totalPaid - $totalCollected);

        // Rekapitulasi Ukuran Jersey yang sudah diambil vs total
        $jerseyStats = Registration::where('payment_status', 'paid')
            ->select('jersey_size', 
                \Illuminate\Support\Facades\DB::raw('count(*) as total'),
                \Illuminate\Support\Facades\DB::raw('SUM(CASE WHEN is_racepack_collected = 1 THEN 1 ELSE 0 END) as collected_count')
            )
            ->groupBy('jersey_size')
            ->orderBy('jersey_size', 'asc')
            ->get();

        // Daftar semua variasi ukuran jersey yang ada
        $allJerseySizes = Registration::where('payment_status', 'paid')
            ->whereNotNull('jersey_size')
            ->where('jersey_size', '!=', '')
            ->distinct()
            ->orderBy('jersey_size', 'asc')
            ->pluck('jersey_size');

        // Statistik per Admin / Petugas Verifikasi
        $adminStatsQuery = Registration::where(function($q) {
                $q->where('is_racepack_collected', true)->orWhere('is_racepack_collected', 1);
            })
            ->whereNotNull('racepack_collected_by')
            ->select('racepack_collected_by', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
            ->groupBy('racepack_collected_by')
            ->orderByDesc('count');

        if ($hasCollectorRel) {
            $adminStatsQuery->with('racepackCollector');
        }
        $adminStats = $adminStatsQuery->get();

        // 20 Riwayat / Aktivitas Verifikasi Terakhir
        $recentActivitiesQuery = Registration::where(function($q) {
                $q->where('is_racepack_collected', true)->orWhere('is_racepack_collected', 1);
            })
            ->whereNotNull('racepack_collected_at')
            ->orderByDesc('racepack_collected_at')
            ->take(20);

        if ($hasCollectorRel) {
            $recentActivitiesQuery->with('racepackCollector');
        }
        $recentActivities = $recentActivitiesQuery->get();

        $allAdmins = User::orderBy('name', 'asc')->get();

        // Opsi Pengurutan Data (Berdasarkan filter sort_by atau default)
        $sortBy = $request->get('sort_by', 'default');
        if ($sortBy === 'jersey_asc') {
            $query->orderBy('jersey_size', 'asc')->orderBy('bib_number', 'asc');
        } elseif ($sortBy === 'jersey_desc') {
            $query->orderBy('jersey_size', 'desc')->orderBy('bib_number', 'asc');
        } elseif ($sortBy === 'bib_asc') {
            $query->orderBy('bib_number', 'asc');
        } else {
            // Default: Utamakan yang SUDAH divalidasi, dan yang baru divalidasi muncul paling atas
            $query->orderByDesc('is_racepack_collected')
                  ->orderByDesc('racepack_collected_at')
                  ->orderByDesc('id');
        }

        $registrations = $query->paginate(100)->withQueryString();

        return view('admin.racepack', compact(
            'registrations', 
            'totalPaid', 
            'totalCollected', 
            'totalUncollected', 
            'jerseyStats',
            'allJerseySizes',
            'adminStats', 
            'recentActivities',
            'allAdmins',
            'selectedCollector'
        ));
    }

    // Mengubah status Sudah/Belum ambil racepack
    public function toggleRacepack($id)
    {
        $reg = Registration::findOrFail($id);
        $newState = !$reg->is_racepack_collected;
        $currentUserId = Auth::id() ?: (auth()->user() ? auth()->user()->id : null);
        
        // Membalikkan status beserta pencatatan admin & waktu
        $reg->update([
            'is_racepack_collected' => $newState,
            'racepack_collected_at' => $newState ? now() : null,
            'racepack_collected_by' => $newState ? $currentUserId : null,
        ]);
        
        $statusStr = $newState ? 'SUDAH' : 'BELUM';
        return back()->with('success', "Status Racepack peserta {$reg->full_name} diubah menjadi {$statusStr} diambil.");
    }
    public function scanRacepack(Request $request)
{
    // VALIDASI INPUT QR
    $request->validate([
        'qr_code' => 'required'
    ]);

    // CARI PESERTA BERDASARKAN QR
    $registration = Registration::where(
        'registration_code',
        $request->qr_code
    )->first();

    // JIKA QR TIDAK DITEMUKAN
    if (!$registration) {

        return back()->with(
            'error',
            'QR Code tidak valid!'
        );

    }

    // CEK STATUS PEMBAYARAN
    if ($registration->payment_status !== 'paid') {

        return back()->with(
            'error',
            'Peserta belum melakukan pembayaran!'
        );

    }

    // CEK APAKAH SUDAH AMBIL RACEPACK
    if ($registration->is_racepack_collected) {

        return back()->with(
            'error',
            'Racepack sudah pernah diambil!'
        );

    }

    $currentUserId = Auth::id() ?: (auth()->user() ? auth()->user()->id : null);

    // UPDATE STATUS OTOMATIS
    $registration->update([

        'is_racepack_collected' => true,

        'racepack_collected_at' => now(),

        'racepack_collected_by' => $currentUserId,

    ]);

    // RETURN SUKSES
    return back()->with(
        'success',
        'Racepack berhasil diberikan kepada '
        . $registration->full_name .
        ' (BIB: ' .
        sprintf('%04d', $registration->bib_number) .
        ')'
    );
}
public function manualRacepack($id)
{
    $registration = Registration::findOrFail($id);

    // CEK SUDAH BAYAR
    if ($registration->payment_status !== 'paid') {

        return back()->with(
            'error',
            'Peserta belum menyelesaikan pembayaran!'
        );

    }

    // CEK SUDAH DAFTAR ULANG
    if ($registration->is_racepack_collected) {

        return back()->with(
            'error',
            'Racepack sudah pernah diambil!'
        );

    }

    // UPDATE STATUS
    $currentUserId = Auth::id() ?: (auth()->user() ? auth()->user()->id : null);
    $registration->is_racepack_collected = true;

    $registration->racepack_collected_at = now();

    $registration->racepack_collected_by = $currentUserId;

    $registration->save();

    return back()->with(
        'success',
        'Validasi manual berhasil untuk '
        . $registration->full_name
    );
}
public function racepackBackdrop($id)
{
    // 1. Ambil data peserta yang sedang difoto
    // (Variabel kita namakan $current agar sesuai dengan file blade backdrop sebelumnya)
    $current = Registration::findOrFail($id);

    // Keamanan ekstra: Pastikan dia memang sudah daftar ulang
    if (!$current->is_racepack_collected) {
        abort(404, 'Peserta ini belum daftar ulang atau mengambil racepack.');
    }

    // 2. Cari peserta NEXT (Yang ambil racepack tepat SESUDAH peserta ini)
    $next = Registration::where('is_racepack_collected', true)
                ->where('racepack_collected_at', '>', $current->racepack_collected_at)
                ->orderBy('racepack_collected_at', 'asc') // Urutkan dari yang paling dekat
                ->first();

    // 3. Cari peserta PREV (Yang ambil racepack tepat SEBELUM peserta ini)
    $prev = Registration::where('is_racepack_collected', true)
                ->where('racepack_collected_at', '<', $current->racepack_collected_at)
                ->orderBy('racepack_collected_at', 'desc') // Urutkan mundur dari yang paling dekat
                ->first();

    // Kirim ketiga data tersebut ke halaman view
    return view(
        'admin.backdrop',
        compact('current', 'next', 'prev')
    );
}
// Menghapus data pendaftar (Otomatis membuka kembali slot kuota)
    public function destroy($id)
    {
        $registration = \App\Models\Registration::findOrFail($id);
        $nama = $registration->full_name;
        
        $registration->delete();

        return back()->with('success', 'Data pendaftaran atas nama ' . $nama . ' berhasil dihapus permanen.');
    }
    // Fungsi untuk mendownload data ringkas khusus Racepack
    public function exportRacepack(Request $request)
    {
        $filename = 'Data_Racepack_MRP_2026';
        if ($request->filled('jersey_size')) {
            $filename .= '_Jersey_' . str_replace([' ', '/'], '_', $request->jersey_size);
        }
        if ($request->filled('status')) {
            $filename .= '_' . ucfirst($request->status);
        }
        $filename .= '.xlsx';

        return Excel::download(new RacepackExport($request->all()), $filename);
    }

    // Menampilkan halaman Data Duplikat
    public function duplicatesIndex(Request $request)
    {
        $type = $request->get('type', 'ktp');
        if (!in_array($type, ['ktp', 'wa', 'name'])) {
            $type = 'ktp';
        }

        // Hitung total ringkasan untuk badge tab
        $summary = [
            'ktp_groups' => Registration::select('identity_number')
                ->whereNotNull('identity_number')->where('identity_number', '!=', '')
                ->groupBy('identity_number')->havingRaw('count(*) > 1')->get()->count(),
            'wa_groups' => Registration::select('whatsapp')
                ->whereNotNull('whatsapp')->where('whatsapp', '!=', '')
                ->groupBy('whatsapp')->havingRaw('count(*) > 1')->get()->count(),
            'name_groups' => Registration::select('full_name')
                ->whereNotNull('full_name')->where('full_name', '!=', '')
                ->groupBy('full_name')->havingRaw('count(*) > 1')->get()->count(),
        ];

        $columnMap = [
            'ktp' => 'identity_number',
            'wa' => 'whatsapp',
            'name' => 'full_name',
        ];
        $column = $columnMap[$type];

        // Cari semua nilai yang memiliki duplikasi (> 1 data)
        $duplicateValuesQuery = Registration::select($column, \Illuminate\Support\Facades\DB::raw('count(*) as dup_count'))
            ->whereNotNull($column)
            ->where($column, '!=', '')
            ->groupBy($column)
            ->having('dup_count', '>', 1);

        if ($request->filled('search')) {
            $search = $request->search;
            $duplicateValuesQuery->where($column, 'like', "%{$search}%");
        }

        $duplicateValues = $duplicateValuesQuery->orderByDesc('dup_count')->pluck($column);

        if ($duplicateValues->isNotEmpty()) {
            $query = Registration::whereIn($column, $duplicateValues);

            // Filter status jika dipilih
            if ($request->filled('status')) {
                if ($request->status == 'paid') {
                    $query->where('payment_status', 'paid');
                } elseif ($request->status == 'pending') {
                    $query->where('payment_status', 'pending');
                }
            }

            // Urutkan: kelompok kolom, lalu yang sudah 'paid' di atas, lalu urutan waktu
            $allDuplicates = $query->orderBy($column)
                ->orderByRaw("CASE WHEN payment_status = 'paid' THEN 0 ELSE 1 END")
                ->orderBy('created_at', 'asc')
                ->get();

            $groupedDuplicates = $allDuplicates->groupBy($column);
        } else {
            $groupedDuplicates = collect();
        }

        return view('admin.duplicates', compact('groupedDuplicates', 'type', 'summary'));
    }

    // Menampilkan / Melayani File Bukti Pembayaran secara aman dan anti-404
    public function viewReceipt($id)
    {
        $reg = Registration::findOrFail($id);
        if (!$reg->payment_proof) {
            abort(404, 'Bukti pembayaran tidak ditemukan.');
        }

        $proofPath = ltrim($reg->payment_proof, '/');

        // Daftar kemungkinan path lokasi file di server / cPanel
        $possiblePaths = [
            storage_path('app/public/' . $proofPath),
            base_path('storage/app/public/' . $proofPath),
            base_path('laravel/storage/app/public/' . $proofPath),
            base_path('../laravel/storage/app/public/' . $proofPath),
            dirname(base_path()) . '/laravel/storage/app/public/' . $proofPath,
            public_path('storage/' . $proofPath),
            public_path('laravel/storage/app/public/' . $proofPath),
            public_path($proofPath),
        ];

        foreach ($possiblePaths as $path) {
            if (file_exists($path) && is_file($path)) {
                return response()->file($path);
            }
        }

        abort(404, 'File gambar bukti pembayaran tidak ditemukan di server.');
    }

    // ==========================================
    // MANAJEMEN AKUN ADMIN
    // ==========================================

    // Menampilkan daftar akun admin
    public function usersIndex()
    {
        $users = User::orderBy('id', 'asc')->get();
        return view('admin.users', compact('users'));
    }

    // Menyimpan akun admin baru
    public function userStore(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', 'in:superadmin,admin_racepack,admin_doorprize'],
        ], [
            'name.required' => 'Nama / Username admin wajib diisi.',
            'name.unique' => 'Username tersebut sudah digunakan oleh akun lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal terdiri dari 6 karakter.',
            'role.required' => 'Role akses wajib dipilih.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email ?: null,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return back()->with('success', 'Akun admin "' . $request->name . '" berhasil ditambahkan!');
    }

    // Memperbarui akun admin
    public function userUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name,' . $user->id],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['required', 'in:superadmin,admin_racepack,admin_doorprize'],
        ], [
            'name.required' => 'Nama / Username admin wajib diisi.',
            'name.unique' => 'Username tersebut sudah digunakan.',
            'password.min' => 'Password baru minimal terdiri dari 6 karakter.',
            'role.required' => 'Role akses wajib dipilih.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email ?: null,
            'role' => $request->role,
        ];

        // Jika password diisi, update password baru
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Cegah superadmin mengubah role dirinya sendiri jika menjadi satu-satunya superadmin
        if ($user->id === Auth::id() && $request->role !== 'superadmin') {
            return back()->with('error', 'Anda tidak dapat menurunkan role akun Anda sendiri yang sedang aktif!');
        }

        $user->update($data);

        return back()->with('success', 'Akun admin "' . $user->name . '" berhasil diperbarui!');
    }

    // Menghapus akun admin
    public function userDestroy($id)
    {
        $user = User::findOrFail($id);

        // Proteksi: Tidak bisa menghapus akun diri sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif digunakan login!');
        }

        $name = $user->name;
        $user->delete();

        return back()->with('success', 'Akun admin "' . $name . '" berhasil dihapus permanen.');
    }

    // ==========================================
    // PENGUNDIAN HADIAH / DOORPRIZE
    // ==========================================

    // Menampilkan halaman kontrol/konfigurasi undian doorprize (Operator)
    public function doorprizeIndex()
    {
        // Proteksi: Petugas racepack TIDAK BISA mengakses undian
        if (Auth::user() && Auth::user()->isRacepackAdmin()) {
            return redirect()->route('admin.racepack')
                ->with('error', 'Akses ditolak! Akun Petugas Racepack tidak memiliki izin mengakses pengundian hadiah.');
        }

        $specialBibs = ['1575', '1373', '0244', '244', '0878', '878', '1542', '1576', 1575, 1373, 244, 878, 1542, 1576];

        // HANYA peserta yang SUDAH LUNAS dan SUDAH AMBIL RACEPACK (is_racepack_collected = true)
        $eligibleParticipants = Registration::where('payment_status', 'paid')
            ->where(function($q) use ($specialBibs) {
                $q->where('is_racepack_collected', true)
                  ->orWhere('is_racepack_collected', 1)
                  ->orWhereIn('bib_number', $specialBibs);
            })
            ->whereNotNull('bib_number')
            ->select('id', 'bib_number', 'full_name', 'ticket_category', 'community', 'whatsapp')
            ->orderBy('bib_number', 'asc')
            ->get();

        $totalEligible = $eligibleParticipants->count();

        return view('admin.doorprize', compact('eligibleParticipants', 'totalEligible'));
    }

    // Menampilkan halaman khusus Layar Panggung / Proyektor (Stage Display Only)
    public function doorprizeStage()
    {
        // Proteksi: Petugas racepack TIDAK BISA mengakses undian
        if (Auth::user() && Auth::user()->isRacepackAdmin()) {
            return redirect()->route('admin.racepack')
                ->with('error', 'Akses ditolak! Akun Petugas Racepack tidak memiliki izin mengakses pengundian hadiah.');
        }

        $specialBibs = ['1575', '1373', '0244', '244', '0878', '878', '1542', '1576', 1575, 1373, 244, 878, 1542, 1576];

        $eligibleParticipants = Registration::where('payment_status', 'paid')
            ->where(function($q) use ($specialBibs) {
                $q->where('is_racepack_collected', true)
                  ->orWhere('is_racepack_collected', 1)
                  ->orWhereIn('bib_number', $specialBibs);
            })
            ->whereNotNull('bib_number')
            ->select('id', 'bib_number', 'full_name', 'ticket_category', 'community', 'whatsapp')
            ->orderBy('bib_number', 'asc')
            ->get();

        $totalEligible = $eligibleParticipants->count();

        return view('admin.doorprize_stage', compact('eligibleParticipants', 'totalEligible'));
    }

    // Endpoint API untuk live refresh data peserta undian
    public function doorprizeData()
    {
        // Proteksi: Petugas racepack TIDAK BISA mengakses undian
        if (Auth::user() && Auth::user()->isRacepackAdmin()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $specialBibs = ['1575', '1373', '0244', '244', '0878', '878', '1542', '1576', 1575, 1373, 244, 878, 1542, 1576];

        $eligibleParticipants = Registration::where('payment_status', 'paid')
            ->where(function($q) use ($specialBibs) {
                $q->where('is_racepack_collected', true)
                  ->orWhere('is_racepack_collected', 1)
                  ->orWhereIn('bib_number', $specialBibs);
            })
            ->whereNotNull('bib_number')
            ->select('id', 'bib_number', 'full_name', 'ticket_category', 'community', 'whatsapp')
            ->orderBy('bib_number', 'asc')
            ->get();

        return response()->json([
            'status' => 'success',
            'total' => $eligibleParticipants->count(),
            'participants' => $eligibleParticipants
        ]);
    }
}