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
        Schema::create('tagihan_admins', function (Blueprint $table) {
            $table->id();

            // Data siswa
            $table->string('nama_siswa');
            $table->string('kelas');
            $table->string('jurusan');

            // Data tagihan
            $table->string('bulan');
            $table->integer('tahun');
            $table->string('jenis_pembayaran');
            $table->decimal('nominal', 15, 0);

            // Tambahan
            $table->text('keterangan')->nullable();

            // Status pembayaran
            $table->string('status')->default('belum_lunas');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan_admins');
    }
};
