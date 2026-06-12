<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            // Tambahkan kolom perpuss_id untuk buku fisik
            if (!Schema::hasColumn('peminjamans', 'perpuss_id')) {
                $table->foreignId('perpuss_id')
                    ->nullable()
                    ->after('book_id')
                    ->constrained('perpusses')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            if (Schema::hasColumn('peminjamans', 'perpuss_id')) {
                $table->dropForeign(['perpuss_id']);
                $table->dropColumn('perpuss_id');
            }
        });
    }
};

