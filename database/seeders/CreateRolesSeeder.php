<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class CreateRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roles = [
            [
                'role' => 'admin'
            ],
            [
                'role' => 'guru'
            ],
            [
                'role' => 'siswa'
            ],

        ];

        foreach ($roles as $key => $role) {
            Role::create($role);
        }
    }
}