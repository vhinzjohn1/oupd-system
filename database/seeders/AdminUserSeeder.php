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
            ['email' => 'oupdadmin@gmail.com'],
            [
                'first_name' => 'OUPD',
                'middle_name' => 'admin',
                'last_name' => 'Admin',
                'user_name' => 'Admin',
                'roles' => 'admin',
                'password' => Hash::make('oupdadmin2k24'),
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
            ['particular_name' => 'EARTHWORK']
        );

        Particular::firstOrCreate(
            ['particular_name' => 'COMPACTION']
        );
        Particular::firstOrCreate(
            ['particular_name' => 'P.P.E']
        );
        Particular::firstOrCreate(
            ['particular_name' => 'PLAIN AND REINFORCED CONCRETE WORK']
        );
        Particular::firstOrCreate(
            ['particular_name' => 'FINISHINGS AND OTHER CIVIL WORK']
        );
        Particular::firstOrCreate(
            ['particular_name' => 'ELECTRICAL WORK']
        );
        Particular::firstOrCreate(
            ['particular_name' => 'MECHANICAL WORK']
        );

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
