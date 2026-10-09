<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Region;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $regions = [
          [
            "name" => "National"
          ],
          [
            "name" => "Adiss Ababa"
          ],
          [
            "name" => "DireDawa"
          ],
          [
            "name" => "Tigray"
          ],
          [
            "name" => "Afar"
          ],
          [
            "name" => "Amhara"
          ],
          [
            "name" => "Oromia"
          ],
          [
            "name" => "Harari"
          ],
          [
            "name" => "Benshangul-Gumuz"
          ],
          [
            "name" => "Somali"
          ],
          [
            "name" => "Gambela"
          ],
          [
            "name" => "Sidama"
          ],
          [
            "name" => "Centeral Ethiopia"
          ],
          [
            "name" => "South Ethiopia"
          ],
          [
            "name" => "South-West Nations"
          ]
        ];

        Region::insert($regions);
    }
}
