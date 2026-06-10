<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promo_klaims', function (Blueprint $table) {
            $table->id();

            // ── Data Pemesan ──
            $table->string('nama', 100);
            $table->string('kota', 100);
            $table->string('no_hp', 20);

            // ── Tiket Domestik 🇮🇩 (harga promo) ──
            $table->unsignedSmallInteger('jumlah_tiket_dewasa')->default(0);   // Rp 70.000
            $table->unsignedSmallInteger('jumlah_tiket_anak')->default(0);     // Rp 60.000

            // ── Tiket Mancanegara 🌏 (harga normal) ──
            $table->unsignedSmallInteger('jumlah_tiket_manca_dewasa')->default(0); // Rp 120.000
            $table->unsignedSmallInteger('jumlah_tiket_manca_anak')->default(0);   // Rp  85.000

            // ── Kunjungan & Pembayaran ──
            $table->date('tanggal_kunjungan');
            $table->unsignedBigInteger('total_harga')->default(0);

            // ── Status ──
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');

            $table->timestamps();

            // ── Index untuk filter & search yang sering dipakai ──
            $table->index('tanggal_kunjungan');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promo_klaims');
    }
};