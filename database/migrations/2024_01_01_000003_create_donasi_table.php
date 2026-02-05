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
        Schema::create('donasi', function (Blueprint $table) {
            $table->id('id_donasi');
            $table->unsignedBigInteger('id_program');
            $table->string('nama_donatur', 100);
            $table->string('email', 100)->nullable();
            $table->string('no_hp', 20)->nullable();
            $table->decimal('nominal', 15, 2);
            $table->enum('metode_pembayaran', ['transfer', 'qris']);
            $table->string('bukti_transfer', 255)->nullable();
            $table->enum('status_donasi', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->string('kode_transaksi', 50)->unique();
            $table->text('pesan')->nullable();
            $table->timestamps();

            $table->foreign('id_program')
                  ->references('id_program')
                  ->on('program_donasi')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donasi');
    }
};
