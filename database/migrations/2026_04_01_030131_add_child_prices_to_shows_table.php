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
    Schema::table('shows', function (Blueprint $table) {
        $table->unsignedInteger('price_domestic_child')->default(60000)->after('price_domestic');
        $table->unsignedInteger('price_foreign_child')->default(85000)->after('price_foreign');
    });
}

public function down(): void
{
    Schema::table('shows', function (Blueprint $table) {
        $table->dropColumn(['price_domestic_child', 'price_foreign_child']);
    });
}
};
