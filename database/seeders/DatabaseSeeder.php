<?php

namespace Database\Seeders;

use App\Models\Reader;
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
        // \App\Models\User::factory(10)->create();
        $this->call([
            OrderSeeder::class,
            ReaderSeeder::class,
            CategorySeeder::class,
            BookSeeder::class,
            UserSeeder::class,
        ]);
    }
}
