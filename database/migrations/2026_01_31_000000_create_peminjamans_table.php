<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->string('judul_buku');
            $table->string('pengarang')->nullable();
            $table->string('nomor_antrian')->unique();
            $table->date('tgl_pinjam');
            $table->date('tgl_kembali')->nullable();
            $table->string('bukti_registrasi')->nullable(); // Path untuk upload screenshot
            $table->enum('status', ['pending', 'diambil', 'dikembalikan'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
