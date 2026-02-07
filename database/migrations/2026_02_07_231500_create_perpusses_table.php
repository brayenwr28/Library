<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perpusses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('publisher');
            $table->string('category')->nullable();
            $table->string('isbn')->nullable()->unique();
            $table->string('status')->default('available');
            $table->unsignedInteger('stock')->default(0);
            $table->unsignedSmallInteger('publication_year')->nullable();
            $table->string('cover_path')->nullable();
            $table->text('summary')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perpusses');
    }
};