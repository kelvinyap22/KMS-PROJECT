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
         if (!Schema::hasColumn('pertanyaans', 'reviewed_by')) {
        Schema::table('pertanyaans', function (Blueprint $table) {
            $table->foreignId('reviewed_by')
                  ->nullable()
                  ->constrained('users');
        });
    }

    if (!Schema::hasColumn('pertanyaans', 'reviewed_at')) {
        Schema::table('pertanyaans', function (Blueprint $table) {
            $table->timestamp('reviewed_at')->nullable();
        });
    }

    if (!Schema::hasColumn('pertanyaans', 'catatan_review')) {
        Schema::table('pertanyaans', function (Blueprint $table) {
            $table->text('catatan_review')->nullable();
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pertanyaans', function (Blueprint $table) {
            //
        });
    }
};
