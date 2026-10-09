<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\OsSupport;

class OsSupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $os_supports = [
            [
              "name"=> "Linux"
            ],
            [
              "name"=> "Microsoft Windows"
            ],
            [
              "name"=> "iOS"
            ],
            [
              "name"=> "macOS"
            ],
            [
              "name"=> "Android"
            ],
            [
              "name"=> "ChromeOS"
            ]
        ];

        OsSupport::insert($os_supports);
    }
}
