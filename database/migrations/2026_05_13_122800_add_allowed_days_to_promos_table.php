
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('promos', function (Blueprint $table) {
            // JSON array: [0=Minggu, 1=Sen, 2=Sel, 3=Rab, 4=Kam, 5=Jum, 6=Sab]
            // NULL = semua hari boleh
            $table->json('allowed_days')->nullable()->after('end_date');
        });
    }

    public function down(): void {
        Schema::table('promos', function (Blueprint $table) {
            $table->dropColumn('allowed_days');
        });
    }
};