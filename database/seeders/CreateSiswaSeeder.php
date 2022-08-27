<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\User;

class CreateSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Siswa::create([
            'nis' => '181113693',
            'nama' => 'Samuel'
        ]);
        User::create([
            'username' => '181113693',
            'password' => bcrypt('123456'),
            'id_profile' => 1,
            'id_role' => 3
        ]);
    }
}