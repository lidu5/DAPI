<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\EhaComponent;

class EhaComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $eha_components = [
          [
            "name"=> "Shared Services"
          ],
          [
            "name"=> "Institution Based HIS and Data Sources"
          ],
          [
            "name"=> "Population Based HIS and Data Sources"
          ],
          [
            "name"=> "Analytics and Business Intelligence"
          ],
          [
            "name"=> "Point of Service HIS"
          ],
          [
            "name"=> "Interoperability Service"
          ],
        ];

        EhaComponent::insert($eha_components);
    }
}
