<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (!Schema::hasColumn('books', 'reference_url')) {
                $table->string('reference_url')->nullable()->after('pdf_path')->comment('Link eksternal referensi atau sumber buku');
            }
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (Schema::hasColumn('books', 'reference_url')) {
                $table->dropColumn('reference_url');
            }
        });
    }
};
