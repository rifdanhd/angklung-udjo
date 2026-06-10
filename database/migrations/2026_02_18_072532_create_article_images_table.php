<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_create_article_images_table.php
public function up()
{
    Schema::create('article_images', function (Blueprint $table) {
        $table->id();
        $table->foreignId('article_id')->constrained()->onDelete('cascade');
        $table->string('image_path');
        $table->integer('order')->default(0);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_images');
    }
};

