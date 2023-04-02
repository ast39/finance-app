<?php

namespace Database\Seeders;

use App\Models\Wallet\WalletCurrency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WalletCurrency::create([
            'title' => 'Российский рубль',
            'abbr'  => 'RUB',
        ]);

        WalletCurrency::create([
            'title' => 'USD',
            'abbr'  => 'Доллар США',
        ]);

        WalletCurrency::create([
            'title' => 'Евро',
            'abbr'  => 'EUR',
        ]);
    }
}
