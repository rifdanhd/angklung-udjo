<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->nullable();        // e.g. "Reguler", "Konser"
            $table->string('event_date')->nullable();      // e.g. "21 Mar" — string biar fleksibel
            $table->text('description')->nullable();
            $table->string('url')->nullable();
            $table->string('image_path')->nullable();      // simpan di storage
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};