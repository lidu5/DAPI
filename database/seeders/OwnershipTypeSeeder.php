<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\OwnershipType;

class OwnershipTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $ownership_types = [
            [
              "name"=> "Private for profit"
            ],
            [
              "name"=> "Non profit organizations"
            ],
            [
              "name"=> "Government"
            ],
            [
              "name"=> "Public"
            ]
        ];

        OwnershipType::insert($ownership_types);
    }
}
