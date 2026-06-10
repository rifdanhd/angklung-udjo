<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table('booking_tickets', function (Blueprint $table) {
        $table->unsignedSmallInteger('jumlah_tiket_kitas_dewasa')
              ->default(0)
              ->after('jumlah_tiket_anak');
    });
}

    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::table('booking_tickets', function (Blueprint $table) {
        $table->dropColumn('jumlah_tiket_kitas_dewasa');
    });
}
};
