<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CreateGuruSeeder::class,
            CreateKeteranganAbsensiSeeder::class,
            CreateRolesSeeder::class,
            CreateSiswaSeeder::class,
            CreateUsersSeeder::class
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
