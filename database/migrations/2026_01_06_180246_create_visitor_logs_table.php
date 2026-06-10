<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up() {
    Schema::create('visitor_logs', function (Blueprint $table) {
        $table->id();
        $table->string('ip_address');
        $table->string('country');
        $table->string('city');
        $table->string('browser'); // Untuk tahu klien pakai Safari/Chrome
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};
