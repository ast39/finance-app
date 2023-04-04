<?php

namespace App\Http\Controllers\Traits;

use App\Http\Mutators\WalletMutator;
use App\Http\Resources\Spend\SpendCategoryResource;
use App\Http\Resources\Wallet\WalletCurrencyResource;
use App\Models\Spend\SpendCategory;
use App\Models\Wallet\Wallet;
use App\Models\Wallet\WalletCurrency;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

trait Dictionarable {

    /**
     * @return ResourceCollection
     */
    private function walletCurrencies(): ResourceCollection
    {
        return WalletCurrencyResource::collection(WalletCurrency::all());
    }

    /**
     * @return ResourceCollection
     */
    private function spendCategories(): ResourceCollection
    {
        return SpendCategoryResource::collection(SpendCategory::all());
    }

    /**
     * @param bool $group
     * @return array
     */
    private function allWallets($group = false): array
    {
        $wallets = Wallet::where('owner_id', Auth::id())
            ->orderBy('currency_id')
            ->orderBy('title')
            ->get();
        $wallets = Arr::map($wallets->toArray(), function($e) {
            return (new WalletMutator())($e);
        });

        if (!$group) {
            return $wallets;
        }

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
