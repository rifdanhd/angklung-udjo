<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking_tickets', function (Blueprint $table) {
            // Tambah setelah kolom 'kota'
            $table->string('negara_asal', 100)->nullable()->after('kota');
        });
    }

    public function down(): void
    {
        Schema::table('booking_tickets', function (Blueprint $table) {
            $table->dropColumn('negara_asal');
        });
    }
};