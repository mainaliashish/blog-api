<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Ashish Mainali',
            'email' => 'mainaliashish@outlook.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password123'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
            'role' => 'admin',
        ]);

        DB::table('users')->insert([
            'name' => 'Ram Lama',
            'email' => 'ram.lama@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password123'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
            'role' => 'user',
        ]);

        DB::table('users')->insert([
            'name' => 'Saurab Sharma',
            'email' => 'saurab@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password123'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
            'role' => 'user',
        ]);
    }
}
