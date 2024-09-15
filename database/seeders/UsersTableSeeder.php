<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password123'),
                'userType' => 'admin',
            ],
            [
                'name' => 'Student User',
                'email' => 'student@gmail.com',
                'password' => Hash::make('password123'),
                'userType' => 'student',
            ],
            [
                'name' => 'Instructor User',
                'email' => 'instructor@gmail.com',
                'password' => Hash::make('password123'),
                'userType' => 'instructor',
            ],
            [
                'name' => 'HR User',
                'email' => 'hr@gmail.com',
                'password' => Hash::make('password123'),
                'userType' => 'hr',
            ],
        ]);
    }
}
