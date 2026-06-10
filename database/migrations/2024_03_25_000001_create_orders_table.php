<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();  // e.g. SUO-20240325-0001
            $table->string('nama_pemesan');
            $table->string('email');
            $table->string('no_telepon');
            $table->date('tanggal_kunjungan');
            $table->integer('jumlah_tiket');          // jumlah tiket yang DIBELI
            $table->integer('jumlah_tiket_gratis');   // hasil B1G1 (= jumlah_tiket)
            $table->integer('total_tiket');           // jumlah_tiket + jumlah_tiket_gratis
            $table->integer('harga_per_tiket');       // dalam rupiah
            $table->integer('total_bayar');           // jumlah_tiket * harga_per_tiket
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->string('bukti_bayar')->nullable(); // path upload bukti
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};