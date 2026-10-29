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
       if (!Schema::hasColumn('users', 'role_id')) {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('role_id');

            $table->foreign('role_id', 'fk_users_roles1')
                  ->references('id')
                  ->on('roles');
        });
    }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       if (Schema::hasColumn('users', 'role_id')) {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('fk_users_roles1');
            $table->dropColumn('role_id');
        });
    }
    }
};
