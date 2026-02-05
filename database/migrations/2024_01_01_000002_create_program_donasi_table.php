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
        Schema::create('program_donasi', function (Blueprint $table) {
            $table->id('id_program');
            $table->unsignedBigInteger('id_kategori');
            $table->string('judul_program', 150);
            $table->text('deskripsi');
            $table->decimal('target_dana', 15, 2);
            $table->decimal('dana_terkumpul', 15, 2)->default(0);
            $table->enum('status_program', ['aktif', 'selesai'])->default('aktif');
            $table->enum('sumber_program', ['yayasan', 'masyarakat']);
            $table->string('gambar', 255)->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('id_kategori')
                  ->references('id_kategori')
                  ->on('kategori_program')
                  ->onDelete('cascade');

            $table->foreign('created_by')
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
        Schema::dropIfExists('program_donasi');
    }
};
