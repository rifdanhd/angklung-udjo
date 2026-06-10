<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('name');                         // Nama promo
            $table->string('code')->unique()->nullable();   // Kode voucher (opsional)
            $table->enum('type', [
                'voucher',      // Kode diskon
                'b1g1',         // Buy 1 Get 1
                'early_bird',   // Early Bird
                'bundling',     // Paket bundling
                'other',        // Lainnya
            ]);
            $table->text('description')->nullable();
            $table->enum('discount_type', ['percent', 'fixed'])->default('percent');
            $table->decimal('discount_value', 10, 2)->default(0); // % atau nominal Rp
            $table->decimal('min_purchase', 10, 2)->default(0);   // Minimum pembelian
            $table->decimal('max_discount', 10, 2)->nullable();   // Maks diskon (untuk %)
            $table->integer('quota')->nullable();                  // null = unlimited
            $table->integer('used_count')->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_active')->default(true);
            $table->string('banner_image')->nullable();
            $table->json('applicable_to')->nullable(); // tiket, souvenir, dll
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};