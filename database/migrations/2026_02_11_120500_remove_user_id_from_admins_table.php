<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('admins', 'user_id')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
            });

            Schema::table('admins', function (Blueprint $table) {
                $table->dropColumn('user_id');
            });
        }

        if (! Schema::hasColumn('admins', 'remember_token')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->rememberToken()->after('password');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('admins', 'user_id')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            });
        }

        if (Schema::hasColumn('admins', 'remember_token')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->dropColumn('remember_token');
            });
        }
    }
};
