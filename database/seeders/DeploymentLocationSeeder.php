<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\DeploymentLocation;

class DeploymentLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $deployment_locations = [
            [
              "name"=> "FMOH/government agency(office)",
              "description"=> "FMOH/government agency(office)"
            ],
            [
              "name"=> "Regional Health Bureau",
              "description"=> "Regional Health Bureau"
            ],
            [
              "name"=> "Zonal Health Department",
              "description"=> "Zonal health department"
            ],
            [
              "name"=> "Woreda Health Office",
              "description"=> "Woreda Health Office"
            ],
            [
              "name"=> "Non-Governmental office ",
              "description"=> "Non-Governmental office"
            ],
            [
              "name"=> "Health Facility",
              "description"=> "Health Facility"
            ],
            [
              "name"=> "Local Cloud",
              "description"=> "Local Cloud"
            ],
            [
              "name"=> "International Cloud",
              "description"=> "International Cloud"
            ]
        ];

        DeploymentLocation::insert($deployment_locations);
    }
}
