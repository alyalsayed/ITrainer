<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Users
        DB::table('users')->insert([
            [
                'name' => 'mark zadworski', 
                'email' => 'alyalsayed56@yahoo.com',
                'password' => Hash::make('password123'),
                'userType' => 'student',
            ],
            [
                'name' => 'daba zadeh',
                'email' => 'aliaboali541@gmail.com',
                'password' => Hash::make('password123'),
                'userType' => 'student',
            ],
            [
                'name' => 'john doe',
                'email' => 'std2@gmail.com',
                'password' => Hash::make('password123'),
                'userType' => 'student',
            ],
            [
                'name' => 'david jones',
                'email' => 'std3@gmail.com',
                'password' => Hash::make('password123'),
                'userType' => 'student',
            ],
            [
                'name' => 'jane harris',
                'email' => 'std4@gmail.com',
                'password' => Hash::make('password123'),
                'userType' => 'student',
            ],
            [
                'name' => 'arthur arnold',
                'email' => 'std5@gmail.com',
                'password' => Hash::make('password123'),
                'userType' => 'student',
            ],
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password123'),
                'userType' => 'admin',
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

       

        // Seed Tracks
        DB::table('tracks')->insert([
            [
               
                'name' => 'Web Development',
                'description' => 'Learn about web development.',
                'start_date' => '2024-01-01',
                'end_date' => '2024-06-01',
            ],
            [
                
                'name' => 'Data Science',
                'description' => 'Introduction to data science.',
                'start_date' => '2024-03-01',
                'end_date' => '2024-09-01',
            ],
        ]);

        DB::table('track_user')->insert([
            [
                'track_id' => 1,
                'user_id' => 1,
            ],
            [
                'track_id' => 1,
                'user_id' => 2,
            ],
            [
                'track_id' => 1,
                'user_id' => 3,
            ],
            [
                'track_id' => 1,
                'user_id' => 4,
            ],
            [
                'track_id' => 1,
                'user_id' => 5,
            ],
            [
                'track_id' => 1,
                'user_id' => 8,
            ]
        ]);
        
        
    }
}
