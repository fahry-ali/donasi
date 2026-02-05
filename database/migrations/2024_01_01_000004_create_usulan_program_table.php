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
        Schema::create('usulan_program', function (Blueprint $table) {
            $table->id('id_usulan');
            $table->unsignedBigInteger('id_user');
            $table->string('judul_usulan', 150);
            $table->string('lokasi', 150);
            $table->text('deskripsi');
            $table->string('foto_pendukung', 255)->nullable();
            $table->enum('status_usulan', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();

            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usulan_program');
    }
};
