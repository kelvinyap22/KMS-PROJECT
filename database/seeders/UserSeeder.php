<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'password' => 'superadmin123',
                'role_id' => 3,
            ],
            [
                'name' => 'Validator',
                'email' => 'validator@gmail.com',
                'password' => 'validator123',
                'role_id' => 2,
            ],
            [
                'name' => 'Data Entry',
                'email' => 'dataentry@gmail.com',
                'password' => 'dataentry123',
                'role_id' => 1,
            ],
            [
                'name' => 'Ariel',
                'email' => 'ariel@gmail.com',
                'password' => 'ariel123',
                'role_id' => 1,
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make($user['password']),
                    'role_id' => $user['role_id'],
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}