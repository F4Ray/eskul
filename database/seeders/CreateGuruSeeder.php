<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guru;

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
            'nip' => '200849280190001',
            'nama' => 'Alfandi Dachlan'
        ]);
    }
}