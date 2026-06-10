<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('promo_klaims', function (Blueprint $table) {
            // Tambah kolom mancanegara setelah kolom anak yang sudah ada
            $table->unsignedSmallInteger('jumlah_tiket_manca_dewasa')->default(0)->after('jumlah_tiket_anak');
            $table->unsignedSmallInteger('jumlah_tiket_manca_anak')->default(0)->after('jumlah_tiket_manca_dewasa');
        });
    }

    public function down(): void
    {
        Schema::table('promo_klaims', function (Blueprint $table) {
            $table->dropColumn(['jumlah_tiket_manca_dewasa', 'jumlah_tiket_manca_anak']);
        });
    }
};