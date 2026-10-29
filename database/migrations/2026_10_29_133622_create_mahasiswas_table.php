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
        if (!Schema::hasTable('mahasiswas')) {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('nrp', 45);
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
