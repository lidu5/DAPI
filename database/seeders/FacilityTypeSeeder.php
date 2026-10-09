<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\FacilityType;

class FacilityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $type = [
            [
              "name"=> "MOH",
            ],
            [
              "name"=> "RHB",
            ],
            [
            " name"=> "ZHO",
            ],
            [
              "name"=> "WoHO",
            ],
            [
              "name"=> "Hospital",
            ],
            [
              "name"=> "Health Center",
            ],
            [
              "name"=> "Health Post",
            ],
            [
              "name"=> "Community",
            ]
        ];

        FacilityType::insert($type);
    }
}
