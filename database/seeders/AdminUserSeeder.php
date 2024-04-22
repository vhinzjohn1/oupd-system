<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Particular;
use App\Models\Project;

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
        $particulars = [
            'EARTHWORK',
            'COMPACTION',
            'P.P.E',
            'PLAIN AND REINFORCED CONCRETE WORK',
            'FINISHINGS AND OTHER CIVIL WORK',
            'ELECTRICAL WORK',
            'MECHANICAL WORK',
            'Moving-In',
            'Moving-Out'
        ];

        foreach ($particulars as $particular) {
            Particular::firstOrCreate(['particular_name' => $particular]);
        }

        Project::firstOrCreate([
            'project_title' => 'CISC Construction Pavements',
            'project_location' => 'University Town Musuan Maramag Bukidnon',
            'project_owner' => 'Central Mindanao University',
            'project_description' => 'On going --',
            'project_contract_duration' => '90 CD',
            'project_date_prepared' => date('Y-m-d', strtotime('01/02/2023')), // Convert date format
            'project_appropriation' => (int) '15000000', // Cast as integer
            'project_source_of_fund' => 'General Fund',
            'project_mode_of_implementation' => 'By Admin',
        ]);

    }
}
