<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\OrganizationUnit;

class OrganizationUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $organization_units = [
            [
              "name"=> "MOH",
              "description"=> "MOH"
            ],
            [
              "name"=> "EPHI",
              "description"=> "EPHI"
            ],
            [
              "name"=> "JSI, Data Use Partnership (DUP)",
              "description"=> "JSI, Data Use Partnership (DUP)"
            ],
            [
              "name"=> "JSI, Digital Health Activities (DHA)",
              "description"=> "JSI, Digital Health Activities (DHA)"
            ],
            [
              "name"=> "JSI, L10K",
              "description"=> "JSI, L10K"
            ],
            [
              "name"=> "ICAP",
              "description"=> "ICAP"
            ],
            [
              "name"=> "JHPIGO",
              "description"=> "JHPIGO"
            ],
            [
              "name"=> "CHAI",
              "description"=> "CHAI"
            ],
            [
              "name"=> "UNICEF Ethiopia",
              "description"=> "UNICEF Ethiopia"
            ],
            [
              "name"=> "AMREF Health Africa",
              "description"=> "AMREF Health Africa"
            ],
            [
              "name"=> "AHRI",
              "description"=> "AHRI"
            ],
            [
              "name"=> "CDC",
              "description"=> "CDC"
            ],
            [
              "name"=> "Regional Health Bureau",
              "description"=> "Regional Health Bureau"
            ],
        ];

        OrganizationUnit::insert($organization_units);
    }
}
