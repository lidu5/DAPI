<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Partner;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $partners = [
            [
              "name"=> "MOH",
              "description"=> "Ministry of Health"
            ]
        ];

        Partner::insert($partners);
    }
}
