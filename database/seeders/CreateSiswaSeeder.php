<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;

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
            'nis' => '0829482291',
            'nama' => 'Ihsanil'
        ]);
        User::create([
            'username' => '0829482291',
            'password' => bcrypt('123456'),
            'id_profile' => 1,
            'id_role' => 3
        ]);
    }
}