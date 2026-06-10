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
    Schema::table('promos', function (Blueprint $table) {
        // Simpan array tanggal: ["2026-05-20", "2026-05-21"]
        $table->json('specific_dates')->nullable()->after('end_date'); 
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promos', function (Blueprint $table) {
            //
        });
    }
};
