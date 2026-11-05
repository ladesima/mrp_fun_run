<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('registration_code')->unique(); // Kode tiket/booking
            
            // 1. DATA DIRI
            $table->string('full_name');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->string('birth_place');
            $table->date('birth_date');
            $table->integer('age');
            $table->string('whatsapp');
            $table->string('email')->nullable(); // Boleh kosong (opsional)
            $table->text('address');
            $table->string('identity_number'); // KTP/SIM/Pelajar

            // 2. DATA EVENT
            $table->enum('ticket_category', ['5K', '10K']);
            $table->integer('price');
            $table->enum('jersey_size', ['XS', 'S', 'M', 'L', 'XL', 'XXL']);
            $table->string('bib_name', 15); // Maks 15 karakter
            $table->string('community')->nullable(); // Opsional

            // 3. KONTAK DARURAT
            $table->string('emergency_name');
            $table->string('emergency_relation');
            $table->string('emergency_phone');

            // 4. INFORMASI KESEHATAN
            $table->string('blood_type')->nullable();
            $table->string('medical_history')->nullable();

            // 5. PERSETUJUAN (Disimpan sebagai boolean 1 / True)
            $table->boolean('health_declaration')->default(true);
            $table->boolean('terms_agreement')->default(true);
            $table->boolean('media_consent')->default(true);

            // DATA SISTEM (Pembayaran)
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->string('payment_proof')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};