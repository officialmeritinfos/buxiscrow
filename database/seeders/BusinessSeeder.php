<?php

namespace Database\Seeders;

use App\Models\Businesses;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Businesses::factory()->count(50)->create();
    }
}
