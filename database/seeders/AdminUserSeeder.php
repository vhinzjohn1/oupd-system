<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\MaterialCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Particular;
use App\Models\Privilege;
use App\Models\Project;
use App\Models\Role;
use App\Models\RolePrivilegeMapping;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        // Role::firstOrCreate(
        //     ['role_name' => 'Admin']
        // );

        // Role::firstOrCreate(
        //     ['role_name' => 'Staff']
        // );

        // Privilege::firstOrCreate(
        //     ['description' => 'masterlist'],
        //     [
        //         'read' => '0',
        //         'write' => '0',
        //         'update' => '0',
        //         'delete' => '0',
        //     ]
        // );

        // Privilege::firstOrCreate(
        //     ['description' => 'transaction'],
        //     [
        //         'read' => '0',
        //         'write' => '0',
        //         'update' => '0',
        //         'delete' => '0',
        //     ]
        // );

        // Privilege::firstOrCreate(
        //     ['description' => 'project'],
        //     [
        //         'read' => '0',
        //         'write' => '0',
        //         'update' => '0',
        //         'delete' => '0',
        //     ]
        // );

        User::firstOrCreate(
            ['first_name' => 'admin'],
            [
                'middle_name' => 'admin',
                'last_name' => 'admin',
                'user_name' => 'admin1',
                'email' => 'admin@gmail.com',
                'roles' => 'admin',
                'password' => bcrypt('admin123'), // Fixed typo: bcrypt instead of bycrpt
            ]
        );

        User::firstOrCreate(
            ['first_name' => 'staff'],
            [
                'middle_name' => 'staff',
                'last_name' => 'staff',
                'user_name' => 'staff123',
                'roles' => 'staff',
                'email' => 'staff@gmail.com',
                'password' => bcrypt('staff123'), // Fixed typo: bcrypt instead of bycrpt
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


        // Define material categories
        $categories = ['Embankment', 'Aggregate Surface Course', 'Portland Cement'];

        foreach ($categories as $categoryName) {
            // Create or retrieve material category
            $materialCategory = MaterialCategory::firstOrCreate(['material_category_name' => $categoryName]);

            // Define materials for each category
            $materials = $this->getMaterialsByCategory($categoryName);

            // Generate materials for each category
            foreach ($materials as $material) {
                $materialName = $material['name'];
                $unit = $material['unit'];
                $price = $material['price'];
                $quarter = $material['quarter'];
                $year = $material['year'];

                // Check if material with the same name exists
                $existingMaterial = Material::where('material_name', $materialName)->first();

                if (!$existingMaterial) {
                    // If material does not exist, create a new one
                    $newMaterial = new Material([
                        'material_name' => $materialName,
                        'unit' => $unit,
                    ]);

                    $newMaterial->category()->associate($materialCategory);
                    $newMaterial->save();

                    // Create a new price instance
                    $newMaterial->prices()->create([
                        'price' => $price,
                        'quarter' => $quarter,
                        'year' => $year,
                    ]);
                }
            }
        }

    }

    private function getMaterialsByCategory($categoryName)
    {
        $materials = [];

        switch ($categoryName) {
            case 'Embankment':
                $materials = [
                    ['name' => 'Common Borrow', 'unit' => 'cu.m', 'price' => 715.00, 'quarter' => '2nd', 'year' => 2020],
                    ['name' => 'Selected Borrow', 'unit' => 'cu.m', 'price' => 550.00, 'quarter' => '2nd', 'year' => 2021],
                    // Add more predefined materials for Embankment category as needed
                ];
                break;
            case 'Aggregate Surface Course':
                $materials = [
                    ['name' => 'Crushed Grading A', 'unit' => 'cu.m', 'price' => 760.00, 'quarter' => '2nd', 'year' => 2022],
                    ['name' => 'Uncrushed Grading B', 'unit' => 'cu.m', 'price' => 860.00, 'quarter' => '2nd', 'year' => 2023],
                    // Add more predefined materials for Aggregate Surface Course category as needed
                ];
                break;
            case 'Portland Cement':
                $materials = [
                    ['name' => 'Ready Mix Concrete 3000psi @ 28 Days', 'unit' => 'cu.m', 'price' => 4600.00, 'quarter' => '2nd', 'year' => 2020],
                    ['name' => 'Curing Compound', 'unit' => 'kg', 'price' => 78.00, 'quarter' => '2nd', 'year' => 2021],
                    // Add more predefined materials for Portland Cement category as needed
                ];
                break;
        }

        return $materials;
    }


}
