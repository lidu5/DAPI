<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Laravue\Acl;
use App\Laravue\Models\Role;
use App\Laravue\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@dhpi.app',
            'phone_number' => '0900111111',
            'password' => Hash::make('Admin!'),
        ]);
        $adminRole = Role::findByName(\App\Laravue\Acl::ROLE_ADMIN);
        $admin->syncRoles($adminRole);
    }
}
