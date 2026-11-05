<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    // Menentukan nama tabel (opsional, tapi disarankan agar lebih eksplisit)
    protected $table = 'registrations';

    // Mendaftarkan kolom apa saja yang diizinkan untuk diisi dari form (Mass Assignment)
    protected $fillable = [
        'registration_code',
        'full_name',
        'gender',
        'birth_place',
        'birth_date',
        'age',
        'whatsapp',
        'email',
        'address',
        'identity_number',
        
        'ticket_category',
        'price',
        'jersey_size',
        'bib_name',
        'bib_number',
        'community',
        
        'emergency_name',
        'emergency_relation',
        'emergency_phone',
        
        'blood_type',
        'medical_history',
        
        'health_declaration',
        'terms_agreement',
        'media_consent',
        
        'payment_status',
        'payment_proof',
        'is_racepack_collected',
        'racepack_collected_at',
        'racepack_collected_by',
    ];

    /**
     * Relasi ke akun admin yang memverifikasi pengambilan racepack
     */
    public function racepackCollector()
    {
        return $this->belongsTo(User::class, 'racepack_collected_by');
    }
}