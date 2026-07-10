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
        Schema::table('perpusses', function (Blueprint $table) {
            $table->string('edisi', 100)->nullable()->after('klasifikasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perpusses', function (Blueprint $table) {
            $table->dropColumn('edisi');
        });
    }
};
