<?php

namespace App\Http\Controllers\Traits;

use App\Http\Mutators\WalletMutator;
use App\Http\Resources\Spend\SpendCategoryResource;
use App\Http\Resources\Wallet\WalletCurrencyResource;
use App\Models\Spend\Spend;
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
        return WalletCurrencyResource::collection(WalletCurrency::all()->sortBy('currency_id'));
    }

    /**
     * @return ResourceCollection
     */
    private function spendCategories(): ResourceCollection
    {
        return SpendCategoryResource::collection(SpendCategory::all()->sortBy('title'));
    }

    /**
     * @param bool $group
     * @return array
     */
    private function allWallets(bool $group = false): array
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

    /**
     * @param bool $group
     * @return array
     */
    private function allSpends(bool $group = false): array
    {
        $spends = Spend::where('owner_id', Auth::id())
            ->orderBy('category_id')
            ->orderBy('wallet_id')
            ->get()
            ->toArray();

        if (!$group) {
            return $spends;
        }

        $spend_list = [];
        foreach ($spends as $spend) {
            if (!key_exists($spend['category']['title'], $spend_list)) {
                $spend_list[$spend['category']['title']] = [];
            }

            if (!key_exists($spend['wallet']['currency']['abbr'], $spend_list[$spend['category']['title']])) {
                $spend_list[$spend['category']['title']][$spend['wallet']['currency']['abbr']] = [];
            }

            $spend_list[$spend['category']['title']][$spend['wallet']['currency']['abbr']][] = $spend;
        }

        return $spend_list;
    }

}
