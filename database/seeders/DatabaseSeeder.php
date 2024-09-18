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

        // Seed Instructors
        // DB::table('instructors')->insert([
        //     [
        //         'user_id' => 1,
        //         'name' => 'John Doe',
        //         'email' => 'john.doe@example.com',
        //     ],
        //     [
        //         'user_id' => 2,
        //         'name' => 'Jane Smith',
        //         'email' => 'jane.smith@example.com',
        //     ],
        // ]);

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

        // Seed Track Sessions
        // DB::table('track_sessions')->insert([
        //     [
        //         'id' => 1,
        //         'name' => 'Introduction to HTML',
        //         'track_id' => 1,  // Ensure this ID exists in tracks table
        //         'session_date' => '2024-01-10',
        //         'description' => 'A session on HTML basics.',
        //         'location' => 'online',
        //     ],
        //     [
        //         'id' => 2,
        //         'name' => 'Advanced Data Analysis',
        //         'track_id' => 2,  // Ensure this ID exists in tracks table
        //         'session_date' => '2024-03-15',
        //         'description' => 'Deep dive into data analysis techniques.',
        //         'location' => 'offline',
        //     ],
        // ]);

        // Seed Students
        // DB::table('students')->insert([
        //     [
        //         'id' => 1,
        //         'name' => 'Alice Johnson',
        //         'email' => 'alice.johnson@example.com',
        //         'track_id' => 1,  // Ensure this ID exists in tracks table
        //     ],
        //     [
        //         'id' => 2,
        //         'name' => 'Bob Brown',
        //         'email' => 'bob.brown@example.com',
        //         'track_id' => 2,  // Ensure this ID exists in tracks table
        //     ],
        // ]);

        // Uncomment and seed additional tables if needed
        // DB::table('attendance')->insert([...]);
        // DB::table('tasks')->insert([...]);
        // DB::table('task_submissions')->insert([...]);
        // DB::table('session_notes')->insert([...]);
    }
}
