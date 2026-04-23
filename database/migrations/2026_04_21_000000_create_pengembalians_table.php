<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peminjaman_id');
            $table->date('tgl_kembali_aktual');
            $table->enum('kondisi_buku', ['baik', 'rusak_ringan', 'rusak_berat'])->default('baik');
            $table->decimal('denda', 10, 2)->default(0);
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->enum('status', ['menunggu_konfirmasi', 'diterima', 'ditolak'])->default('menunggu_konfirmasi');
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Foreign Keys
            $table->foreign('peminjaman_id')->references('id')->on('peminjamans')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
