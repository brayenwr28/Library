<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('perpusses', function (Blueprint $table) {
            $table->string('registration_number', 100)->nullable()->after('id');
            $table->string('klasifikasi', 100)->nullable()->after('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('perpusses', function (Blueprint $table) {
            $table->dropColumn(['registration_number', 'klasifikasi']);
        });
    }
};
