<?php

namespace Database\Seeders;

use App\Models\Reader;
use Database\Factories\ReaderFactory;
use Illuminate\Database\Seeder;

class ReaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Reader::factory()
            ->count(200)
            ->create();
    }
}
