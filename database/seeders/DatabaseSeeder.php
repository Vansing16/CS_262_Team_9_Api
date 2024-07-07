<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Create technicians
        $technicians = User::factory()->count(2)->create([
            'role' => 'technician',
        ]);

        // Create specific technicians
        User::create([
            'name' => 'Test Technician 1',
            'email' => 'tech1@gmail.com',
            'password' => bcrypt('password'),
            'phone' => '1234567890',
            'date_of_birth' => '1990-01-01',
            'nationality' => 'India',
            'profile_image' => 'profile.jpg',
            'status' => 'offline',
            'role' => 'technician',
        ]);

        User::create([
            'name' => 'Test Technician 2',
            'email' => 'tech2@gmail.com',
            'password' => bcrypt('password'),
            'phone' => '0987654321',
            'date_of_birth' => '1985-05-05',
            'nationality' => 'USA',
            'profile_image' => 'profile2.jpg',
            'status' => 'offline',
            'role' => 'technician',
        ]);

        // Create customers
        User::factory()->count(2)->create([
            'role' => 'customer',
        ]);

        // Create specific customers
        User::create([
            'name' => 'Test Customer 1',
            'email' => 'customer1@gmail.com',
            'password' => bcrypt('password'),
            'phone' => '1122334455',
            'date_of_birth' => '2000-01-01',
            'nationality' => 'UK',
            'profile_image' => 'profile.jpg',
            'role' => 'customer',
        ]);

        User::create([
            'name' => 'Test Customer 2',
            'email' => 'customer2@gmail.com',
            'password' => bcrypt('password'),
            'phone' => '5544332211',
            'date_of_birth' => '1995-12-12',
            'nationality' => 'Canada',
            'profile_image' => 'profile2.jpg',
            'role' => 'customer',
        ]);
    }
}

