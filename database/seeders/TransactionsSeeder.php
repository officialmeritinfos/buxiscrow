<?php

namespace Database\Seeders;

use App\Models\Transactions;
use Illuminate\Database\Seeder;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transactions::factory()
                    ->count(20)
                    ->create();
    }
}
