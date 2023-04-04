<?php

namespace Database\Seeders;

use App\Models\Spend\Spend;
use Illuminate\Database\Seeder;

class SpendSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Spend::create([
            'owner_id'    => 1,
            'wallet_id'   => 1,
            'category_id' => 3,
            'amount'      => 1000,
            'note'        => 'Бензин 95',
        ]);

        Spend::create([
            'owner_id'    => 1,
            'wallet_id'   => 1,
            'category_id' => 4,
            'amount'      => 500,
            'note'        => 'Кофейня',
        ]);
    }
}
