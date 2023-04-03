<?php

namespace App\Http\Controllers\Traits;

use App\Http\Resources\Wallet\WalletCurrencyResource;
use App\Models\Wallet\WalletCurrency;
use Illuminate\Http\Resources\Json\ResourceCollection;

trait Dictionarable {

    /**
     * @return ResourceCollection
     */
    private function walletCurrencies(): ResourceCollection
    {
        return WalletCurrencyResource::collection(WalletCurrency::all());
    }
}
