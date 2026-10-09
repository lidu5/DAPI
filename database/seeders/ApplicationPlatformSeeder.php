<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ApplicationPlatform;

class ApplicationPlatformSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $application_platforms = [
            [
              "name" => "AI",
              "description" => "Artificial intellegence"
            ],
            [
              "name" => "Web",
              "description" => "Web application"            
            ],
            [
              "name" => "IVR",
              "description" => "Interactive voice response"
            ],
            [
              "name" => "SMS",
              "description" => "Short Message Service"
            ],
            [
              "name" => "Mobile app",
              "description" => "Mobile application"
            ],
            [
              "name" => "Desktop",
              "description" => "Desktop application"
            ]
        ];

        ApplicationPlatform::insert($application_platforms);
    }
}
