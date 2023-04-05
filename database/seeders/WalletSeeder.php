<?php

namespace Database\Seeders;

use App\Models\Wallet\Wallet;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Wallet::create([
            'currency_id' => 1,
            'owner_id'    => 1,
            'title'       => 'Кошелек №1',
            'note'        => 'Для рублевых трат',
            'amount'      => 30000,
        ]);

        Wallet::create([
            'currency_id' => 2,
            'owner_id'    => 1,
            'title'       => 'Кошелек №2',
            'note'        => 'Для трат в долларах',
            'amount'      => 550,
        ]);

        Wallet::create([
            'currency_id' => 3,
            'owner_id'    => 1,
            'title'       => 'Кошелек №3',
            'note'        => 'Для трат в евро',
            'amount'      => 0,
        ]);
    }
}
