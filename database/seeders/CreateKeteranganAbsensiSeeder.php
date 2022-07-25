<?php

namespace Database\Seeders;

use App\Models\KeteranganAbsensi;
use Illuminate\Database\Seeder;

class CreateKeteranganAbsensiSeeder extends Seeder
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
                'keterangan' => 'Hadir'
            ],
            [
                'keterangan' => 'Sakit'
            ],
            [
                'keterangan' => 'Izin'
            ],
            [
                'keterangan' => 'Cuti'
            ],
            [
                'keterangan' => 'Alpa'
            ],

        ];

        foreach ($roles as $key => $role) {
            KeteranganAbsensi::create($role);
        }
    }
}