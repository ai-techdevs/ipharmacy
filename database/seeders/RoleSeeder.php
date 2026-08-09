<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::updateOrCreate(
            ['id' => 1], // Check by email
            [
                'name' => 'admin',
                'display_name' => 'Admin',
                'is_visible' => '1',

            ]
        );

        Role::updateOrCreate(
            ['id' => 2],
            [
                'name' => 'sub_admin',
                'display_name' => 'Sub Admin',
                'is_visible' => '1',

            ]
        );

        Role::updateOrCreate(
            ['id' => 3],
            [
                'name' => 'user',
                'display_name' => 'User',
                'is_visible' => '1',

            ]
        );
    }
}
