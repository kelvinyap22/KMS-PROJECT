<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $roles = [
            'Data Entry',
            'Validator',
            'Super Admin',
        ];

        foreach ($roles as $namaRole) {
            DB::table('roles')->updateOrInsert(
                ['nama  ' => $namaRole],
                ['updated_at' => now(), 'created_at' => now()]
            );
        }
    }
}
