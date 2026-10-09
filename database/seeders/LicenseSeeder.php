<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\License;

class LicenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $licenses = [
            [
              "name"=> "Free"
            ],
            [
              "name"=> "Open source"
            ],
            [
              "name"=> "Proprietary"
            ]
        ];

        License::insert($licenses);
    }
}
