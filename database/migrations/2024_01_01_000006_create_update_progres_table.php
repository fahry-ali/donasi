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
        Schema::create('update_progres', function (Blueprint $table) {
            $table->id('id_update');
            $table->unsignedBigInteger('id_program');
            $table->text('deskripsi_update');
            $table->integer('persentase');
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
        Schema::dropIfExists('update_progres');
    }
};
