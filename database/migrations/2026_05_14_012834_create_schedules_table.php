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
    Schema::create('schedules', function (Blueprint $table) {
        $table->id();
        $table->date('date');           // Tanggal (misal: 2026-05-14)
        $table->string('session_id');    // pagi, siang, sore, reg
        $table->string('session_time');  // "10.00 - 11.30 WIB"
        $table->integer('capacity')->default(20); // Stok kursi
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
