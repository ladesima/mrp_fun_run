<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registration;
use Illuminate\Support\Str; // Untuk membuat kode tiket otomatis

class UserController extends Controller
{
    public function landingPage()
    {
        return view('landing'); // Pastikan ini mengarah ke file welcome/landing page Anda
    }

    public function showRegisterForm($kategori)
    {
        // PENDAFTARAN SEMUA KATEGORI RESMI DITUTUP (KUOTA PENUH)
        return redirect()->url('/')->with('error', 'MOHON MAAF, PENDAFTARAN MRP FUN RUN 2026 RESMI DITUTUP! Seluruh kuota peserta telah terpenuhi (KUOTA HABIS).');
    }

    public function processRegister(Request $request)
    {
        // PENDAFTARAN SEMUA KATEGORI RESMI DITUTUP (KUOTA PENUH)
        return redirect()->url('/')->with('error', 'MOHON MAAF, PENDAFTARAN RESMI DITUTUP! Sistem tidak lagi menerima pendaftaran baru karena seluruh kuota telah terpenuhi.');
    }

    public function paymentPage($code)
    {
        // Cari data pendaftar berdasarkan kode registrasi
        $registration = Registration::where('registration_code', $code)->firstOrFail();
        
        return view('payment', compact('registration'));
    }

    public function uploadProof(Request $request, $code)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maks 2MB
        ]);

        $registration = Registration::where('registration_code', $code)->firstOrFail();

        // Simpan gambar bukti transfer ke folder public/storage/receipts
        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('receipts', 'public');
            
            $registration->update([
                'payment_proof' => $path,
                'payment_status' => 'pending' // Status menunggu verifikasi admin
            ]);
        }

        return back()->with('success', 'Bukti pembayaran berhasil diunggah! Mohon tunggu verifikasi admin.');
    }

    public function showTicket($code)
    {
        // Cari data peserta berdasarkan kode booking
        $registration = Registration::where('registration_code', $code)->firstOrFail();

        // PROTEKSI: Jika status pembayaran BELUM lunas ('paid'), lempar kembali ke halaman bayar
        if ($registration->payment_status !== 'paid') {
            return redirect()->route('payment.page', ['code' => $code])
                             ->with('error', 'Pembayaran Anda belum terverifikasi oleh panitia.');
        }

        return view('ticket', compact('registration'));
    }

    // Menampilkan halaman Cek Status
    public function checkStatusPage()
    {
        return view('check-status');
    }

    // Memproses pencarian berdasarkan Nomor WhatsApp atau NIK
    public function findTicket(Request $request)
    {
        $request->validate([
            'search_key' => 'required'
        ]);

        // Cari data pendaftar berdasarkan WhatsApp ATAU Nomor KTP (NIK)
        $registration = Registration::where('whatsapp', $request->search_key)
                                    ->orWhere('identity_number', $request->search_key)
                                    ->first();

        if ($registration) {
            // Jika ketemu, arahkan kembali ke halaman pembayaran mereka
            // (Halaman pembayaran sudah otomatis menampilkan tombol E-Ticket jika statusnya sudah Lunas)
            return redirect()->route('payment.page', $registration->registration_code);
        }

        // Jika tidak ketemu, kembalikan ke form dengan pesan error
        return back()->with('error', 'Data pendaftaran tidak ditemukan. Pastikan Nomor WhatsApp atau KTP sudah benar.');
    }

    // Menampilkan halaman Daftar Peserta Publik
    public function participantList(Request $request)
    {
        // Hanya ambil peserta yang status pembayarannya sudah 'paid' (Lunas)
        $query = Registration::where('payment_status', 'paid');

        // Fitur Pencarian Nama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('full_name', 'like', "%{$search}%");
        }

        // Fitur Filter Kategori
        if ($request->filled('category')) {
            $query->where('ticket_category', $request->category);
        }

        // Ambil data dan urutkan berdasarkan waktu pendaftaran
        $participants = $query->orderBy('created_at', 'asc')->get();

        return view('participants', compact('participants'));
    }
}