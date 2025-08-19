<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id(); // Kolom id, auto-increment
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi ke users
            $table->foreignId('ruangan_id')->constrained()->onDelete('cascade'); // Relasi ke ruangans
            $table->dateTime('start_time'); // Waktu mulai booking
            $table->dateTime('end_time'); // Waktu selesai booking
            $table->timestamps(); // created_at dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};