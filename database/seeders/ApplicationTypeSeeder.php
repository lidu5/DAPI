<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 

class ApplicationTypeSeeder extends Seeder
{
    
    public function run()
    {
        DB::table('application_types')->insert([
            ['name' => 'Facility management information systems', 'eha_component_id' => 1],
            ['name' => '(Health) Facility registries', 'eha_component_id' => 1],
            ['name' => 'Health worker registry', 'eha_component_id' => 1],
            ['name' => 'Identification registries and directories', 'eha_component_id' => 1],
            ['name' => 'Immunization information systems', 'eha_component_id' => 1],
            ['name' => 'Master patient index', 'eha_component_id' => 1],
            ['name' => 'Product catalogues', 'eha_component_id' => 1],
            ['name' => 'Public Key directories', 'eha_component_id' => 1],
            ['name' => 'Terminology and classification systems', 'eha_component_id' => 1],
            ['name' => 'Blood bank information management systems ', 'eha_component_id' => 2],
            ['name' => 'Health finance-related information systems  ', 'eha_component_id' => 2],
            ['name' => 'Health program monitoring systems  ', 'eha_component_id' => 2],
            ['name' => 'Human resource information systems ', 'eha_component_id' => 2],
            ['name' => 'Learning and training systems', 'eha_component_id' => 2],
            ['name' => 'Logistics management information systems (LMIS) ', 'eha_component_id' => 2],
            ['name' => 'Patient Administration systems', 'eha_component_id' => 2],
            ['name' => 'Research information systems ', 'eha_component_id' => 2],
            ['name' => 'Census and population information systems   ', 'eha_component_id' => 3],
            ['name' => 'Civil registration and vital statistics (CRVS) systems', 'eha_component_id' => 3],
            ['name' => 'Analytics Systems', 'eha_component_id' => 4],
            ['name' => 'Data warehouses', 'eha_component_id' => 4],
            ['name' => 'Communication systems  ', 'eha_component_id' => 5],
            ['name' => 'Community-based information systems  ', 'eha_component_id' => 5],
            ['name' => 'Decision support systems ', 'eha_component_id' => 5],
            ['name' => 'Diagnostics information systems  ', 'eha_component_id' => 5],
            ['name' => 'Electronic medical record systems    ', 'eha_component_id' => 5],
            ['name' => 'Laboratory information systems   ', 'eha_component_id' => 5],
            ['name' => 'Personal health records  ', 'eha_component_id' => 5],
            ['name' => 'Pharmacy information systems ', 'eha_component_id' => 5],
            ['name' => 'Telehealth systems  ', 'eha_component_id' => 5],
            ['name' => 'Finance and insurance services ', 'eha_component_id' => 5],
            ['name' => 'Data interchange and interoperability   ', 'eha_component_id' => 6],
            








        ]);
    }
    
    

}
