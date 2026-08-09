<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      // Admin User
        User::updateOrCreate(
            ['id' => 1], // Check by email
            [
                'email' => 'admin@gmail.com',
                'name' => 'Admin User',
                'password' => Hash::make('123456'),
                'role_id' => '1',
            ]
        );

        // Normal User
        User::updateOrCreate(
            ['id' => 2],
            [
                'email' => 'user@gmail.com',
                'name' => 'John Doe',
                'password' => Hash::make('123456'),
                'role_id' => '2',
            ]
        );


    }
}
