<?php

namespace Database\Seeders;

use App\Models\Spend\SpendCategory;
use App\Models\Wallet\WalletPayment;
use Illuminate\Database\Seeder;

class WalletPaymentsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WalletPayment::create([
            'wallet_id' => 1,
            'amount'    => 5000,
            'note'      => 'Пополнение 1',
        ]);

        WalletPayment::create([
            'wallet_id' => 1,
            'amount'    => -1500,
            'note'      => 'Снятие 1',
        ]);

        WalletPayment::create([
            'wallet_id' => 3,
            'amount'    => 1000,
            'note'      => 'Пополнение 2',
        ]);
    }
}
