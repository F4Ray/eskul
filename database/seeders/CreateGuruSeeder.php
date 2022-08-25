<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guru;
use App\Models\User;

class CreateGuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Guru::create([
            'nama' => 'Ihsanul'
        ]);
        User::create([
            'username' => '00001',
            'password' => bcrypt('123456'),
            'id_profile' => 1,
            'id_role' => 2
        ]);
    }
}