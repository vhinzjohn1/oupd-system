<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Particular;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create admin user if not exists
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'first_name' => 'Admin',
                'middle_name' => 'admin',
                'last_name' => 'admin',
                'user_name' => 'admin',
                'roles' => 'admin',
                'password' => Hash::make('admin123'),
            ]
        );

        // Create staff user if not exists
        User::firstOrCreate(
            ['email' => 'staff@gmail.com'],
            [
                'first_name' => 'Staff',
                'middle_name' => 'staff',
                'last_name' => 'staff',
                'user_name' => 'staff',
                'roles' => 'staff',
                'password' => Hash::make('staff123'),
            ]
        );

        Particular::firstOrCreate(
            ['particular_name' => 'EARTHWORK'],
            ['description' => 'Not Set']
        );

        Particular::firstOrCreate(
            ['particular_name' => 'COMPACTION'],
            ['description' => 'Not Set']
        );
        Particular::firstOrCreate(
            ['particular_name' => 'P.P.E'],
            ['description' => 'Not Set']
        );
        Particular::firstOrCreate(
            ['particular_name' => 'PLAIN AND REINFORCED CONCRETE WORK'],
            ['description' => 'Not Set']
        );
        Particular::firstOrCreate(
            ['particular_name' => 'FINISHINGS AND OTHER CIVIL WORK'],
            ['description' => 'Not Set']
        );
        Particular::firstOrCreate(
            ['particular_name' => 'ELECTRICAL WORK'],
            ['description' => 'Not Set']
        );
        Particular::firstOrCreate(
            ['particular_name' => 'MECHANICAL WORK'],
            ['description' => 'Not Set']
        );
    }
}
