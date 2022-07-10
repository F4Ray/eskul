<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'username' => 'admin',
                'id_role' => 1,
                'password' => bcrypt('123456'),
                'id_profile' => 1
            ],
            [

                'username' => 'Guru',
                'id_role' => 2,
                'password' => bcrypt('123456'),
                'id_profile' => 1
            ],
            [

                'username' => 'user@itsolutionstuff.com',
                'id_role' => 3,
                'password' => bcrypt('123456'),
                'id_profile' => 1
            ],
        ];

        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}