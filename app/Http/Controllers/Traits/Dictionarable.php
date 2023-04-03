<?php

namespace App\Http\Controllers\Traits;

use App\Http\Mutators\WalletMutator;
use App\Http\Resources\Wallet\WalletCurrencyResource;
use App\Models\Wallet\Wallet;
use App\Models\Wallet\WalletCurrency;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;

trait Dictionarable {

    /**
     * @return ResourceCollection
     */
    private function walletCurrencies(): ResourceCollection
    {
        return WalletCurrencyResource::collection(WalletCurrency::all());
    }

    /**
     * @return array
     */
    private function allWallets(): array
    {
        $wallets = Wallet::all();
        $wallets = Arr::map($wallets->toArray(), function($e) {
            return (new WalletMutator())($e);
        });

        $wallet_list = [];
        foreach ($wallets as $wallet) {
            if (!key_exists($wallet['currency']['abbr'], $wallet_list)) {
                $wallet_list[$wallet['currency']['abbr']] = [];
            }

            $wallet_list[$wallet['currency']['abbr']][] = $wallet;
        }

        return $wallet_list;
    }
}
