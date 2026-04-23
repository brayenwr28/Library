<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            // Tambah kolom book_id jika belum ada
            if (!Schema::hasColumn('peminjamans', 'book_id')) {
                $table->unsignedBigInteger('book_id')->nullable()->after('member_id');
                $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
            }
        });

        // Update status enum untuk support MENUNGGU_KONFIRMASI, DIAMBIL, DIKEMBALIKAN, DITOLAK
        DB::statement("ALTER TABLE peminjamans MODIFY status ENUM('menunggu_konfirmasi', 'diambil', 'ditolak', 'dikembalikan') DEFAULT 'menunggu_konfirmasi'");
    }

    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            // Restore status enum ke yang lama jika rollback
        });

        DB::statement("ALTER TABLE peminjamans MODIFY status ENUM('pending', 'diambil', 'dikembalikan') DEFAULT 'pending'");
    }
};
