<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom doku_channel ke booking_tickets.
     * Menyimpan channel Doku yang digunakan (QRIS, VA BRI, OVO, dll).
     */
    public function up(): void
    {
        Schema::table('booking_tickets', function (Blueprint $table) {
            $table->string('doku_channel', 40)->nullable()->after('payment_method');
        });
    }

    public function down(): void
    {
        Schema::table('booking_tickets', function (Blueprint $table) {
            $table->dropColumn('doku_channel');
        });
    }
};
