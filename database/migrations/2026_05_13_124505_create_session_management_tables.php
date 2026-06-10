<?php
// database/migrations/xxxx_create_session_management_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // ── MASTER SESSIONS ────────────────────────────────────────
        Schema::create('show_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 20)->unique(); // 'pagi','siang','sore','reg'
            $table->string('name', 100); // 'Sesi Pagi', 'Regular Show'
            $table->string('time', 60); // '10.00 - 11.30 WIB'
            $table->integer('default_capacity')->default(20);
            $table->json('available_days'); // [0,6] untuk minggu & sabtu
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // ── AVAILABILITY PER TANGGAL ───────────────────────────────
        Schema::create('performance_schedules', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('session_id', 20);
            $table->integer('total_capacity'); // Total kursi tersedia
            $table->integer('booked')->default(0); // Sudah terpesan
            $table->integer('remaining')->virtualAs('total_capacity - booked'); // Auto calculated
            $table->boolean('is_open')->default(true); // Admin bisa tutup manual
            $table->text('notes')->nullable(); // Catatan khusus
            $table->timestamps();
            
            $table->unique(['date', 'session_id']);
            $table->foreign('session_id')
                  ->references('session_id')
                  ->on('show_sessions')
                  ->onDelete('cascade');
            
            $table->index(['date', 'is_open']);
        });

        // ── UPDATE BOOKING_TICKETS ─────────────────────────────────
        // Cek apakah kolom sudah ada
        if (!Schema::hasColumn('booking_tickets', 'total_tickets')) {
            Schema::table('booking_tickets', function (Blueprint $table) {
                $table->integer('total_tickets')->after('session_time')
                      ->virtualAs('jumlah_tiket_dewasa + jumlah_tiket_anak + jumlah_tiket_manca_dewasa + jumlah_tiket_manca_anak');
            });
        }
    }

    public function down()
    {
        Schema::table('booking_tickets', function (Blueprint $table) {
            $table->dropColumn('total_tickets');
        });
        Schema::dropIfExists('session_availability');
        Schema::dropIfExists('sessions');
    }
};