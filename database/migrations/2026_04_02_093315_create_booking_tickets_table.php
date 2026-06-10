<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code', 30)->unique();       // SAU-YYYYMMDD-XXXX

            // ── Data Pemesan ──
            $table->string('nama', 100);
            $table->string('no_hp', 30);
            $table->string('email', 120);
            $table->string('kota', 100)->nullable();

            // ── Jadwal ──
            $table->date('tanggal_kunjungan');
            $table->string('session_id', 20);                  // pagi | siang | sore | reg
            $table->string('session_time', 60);                // "15.30 – 17.00 WIB"

            // ── Tiket Domestik 🇮🇩 ──
            $table->unsignedSmallInteger('jumlah_tiket_dewasa')->default(0);        // Rp 85.000
            $table->unsignedSmallInteger('jumlah_tiket_anak')->default(0);          // Rp 60.000

            // ── Tiket Mancanegara 🌏 ──
            $table->unsignedSmallInteger('jumlah_tiket_manca_dewasa')->default(0);  // Rp 120.000
            $table->unsignedSmallInteger('jumlah_tiket_manca_anak')->default(0);    // Rp 85.000

            // ── Promo & Harga ──
            $table->string('promo_code', 30)->nullable();
            $table->unsignedInteger('discount_amount')->default(0);
            $table->unsignedBigInteger('subtotal')->default(0);
            $table->unsignedBigInteger('total_harga')->default(0);

            // ── Status & Tracking ──
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])
                  ->default('pending');
            $table->timestamp('wa_opened_at')->nullable();

            $table->timestamps();

            // ── Index ──
            $table->index('tanggal_kunjungan');
            $table->index('status');
            $table->index('booking_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_tickets');
    }
};