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
       if (!Schema::hasTable('saran_pertanyaans')) {
        Schema::create('saran_pertanyaans', function (Blueprint $table) {
            $table->id();

            $table->integer('mahasiswa_id');
            $table->foreign('mahasiswa_id')
                  ->references('id')
                  ->on('mahasiswas');

            $table->text('pertanyaan');

            $table->unsignedBigInteger('ditangani_oleh')->nullable();
            $table->foreign('ditangani_oleh')
                  ->references('id')
                  ->on('users');

            $table->enum('status', [
                'baru',
                'diproses',
                'selesai',
                'ditolak',
            ])->default('baru');

            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saran_pertanyaans');
    }
};
