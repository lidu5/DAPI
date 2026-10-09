<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\HealthProfessionalGroup;

class HealthProfessionalSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
      //        
      $health_professionals = [
          [
            "name"=> "Physicians",
            "description"=> "Physicians"
          ],
          [
            "name"=> "Health Extension Workers (HEW) ",
            "description"=> "Health Extension Workers (HEW)"
          ],
          [
            "name"=> "Health care team ",
            "description"=> "Health care team"
          ],
          [
            "name"=> "Surveillance officers",
            "description"=> "Surveillance officers"
          ],
          [
            "name"=> "M&E officers",
            "description"=> "M&E officers"
          ],
          [
            "name"=> "Human Resource Admin/office",
            "description"=> "Human Resource Admin/office"
          ],
          [
            "name"=> "Laboratory technician",
            "description"=> "Laboratory technician"
          ],
          [
            "name"=> "Health Logistics Manager",
            "description"=> "Health Logistics Manager"
          ],
          [
            "name"=> "IT Manager",
            "description"=> "IT Manager"
          ],
          [
            "name"=> "IT professional",
            "description"=> "IT professional"
          ],
          [
            "name"=> "Developer",
            "description"=> "Developer"
          ]
      ];

      HealthProfessionalGroup::insert($health_professionals);
  }
}
