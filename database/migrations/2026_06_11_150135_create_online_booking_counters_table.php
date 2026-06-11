<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('online_booking_counters', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal')->unique();
            $table->integer('total_klik')->default(0);
            $table->integer('kapasitas')->default(20);
            $table->boolean('is_closed')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('online_booking_counters');
    }
};