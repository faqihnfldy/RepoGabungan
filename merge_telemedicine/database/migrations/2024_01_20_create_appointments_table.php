<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('patient_id')->constrained('users'); // Relasi dengan pasien
            $table->foreignId('doctor_id')->constrained('users'); // Relasi dengan dokter
            $table->dateTime('appointment_date'); // Tanggal dan waktu appointment
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending'); // Status appointment
            $table->text('notes')->nullable(); // Catatan, boleh kosong
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointments');
    }
};
