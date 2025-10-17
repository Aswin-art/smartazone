<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $users = [
            [
                'name'              => 'Super Admin',
                'nik'               => '1000000000000001',
                'email'             => 'admin@gmail.com',
                'phone'             => '081234567890',
                'emergency_contact' => '081234567891',
                'password'          => Hash::make('password'),
                'user_type'         => 'superadmin',
                'mountain_id'       => 1,
            ],
            [
                'name'              => 'Admin Gunung',
                'nik'               => '1000000000000002',
                'email'             => 'gunung@gmail.com',
                'phone'             => '081234567892',
                'emergency_contact' => '081234567893',
                'password'          => Hash::make('password'),
                'user_type'         => 'admin',
                'mountain_id'       => 1,
            ],
            [
                'name'              => 'Pendaki Uji Coba',
                'nik'               => '1000000000000003',
                'email'             => 'pendaki@gmail.com',
                'phone'             => '081234567894',
                'emergency_contact' => '081234567895',
                'password'          => Hash::make('password'),
                'user_type'         => 'pendaki',
                'mountain_id'       => 1,
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']], 
                array_merge($user, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
