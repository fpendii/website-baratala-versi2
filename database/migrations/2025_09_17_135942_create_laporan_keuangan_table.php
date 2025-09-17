<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanKeuanganTable extends Migration
{
    public function up()
    {
        Schema::create('laporan_keuangan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_keuangan');
            $table->unsignedBigInteger('id_pengguna');
            $table->date('tanggal');
            $table->enum('tipe', ['pemasukan', 'pengeluaran']);
            $table->decimal('nominal', 15, 2);
            $table->text('deskripsi')->nullable();
            $table->string('bukti_transaksi')->nullable();
            $table->string('metode_pembayaran')->nullable();
            $table->timestamps();

            $table->foreign('id_keuangan')->references('id')->on('keuangan')->onDelete('cascade');
            $table->foreign('id_pengguna')->references('id')->on('pengguna')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_keuangan');
    }
}
