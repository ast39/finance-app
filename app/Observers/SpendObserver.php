<?php

namespace App\Observers;

use App\Models\Spend\Spend;
use App\Models\Spend\SpendCategory;
use App\Models\Wallet\WalletPayment;
use Illuminate\Support\Facades\Auth;

class SpendObserver {

    /**
     * @param Spend $spend
     * @return void
     */
    public function created(Spend $spend): void
    {
        WalletPayment::create([
            'wallet_id' => $spend->wallet_id,
            'spend_id'  => $spend->spend_id,
            'amount'    => $spend->amount,
            'note'      => SpendCategory::where('category_id', $spend->category_id)->first()->title . ': ' . $spend->note,
        ]);
    }

    /**
     * @param Spend $spend
     * @return void
     */
    public function updated(Spend $spend): void
    {
        WalletPayment::where('spend_id', $spend->spend_id)
            ->update([
                'amount' => $spend->amount,
                'note'   => SpendCategory::where('category_id', $spend->category_id)->first()->title . ': ' . $spend->note,
            ]);
    }

    /**
     * @param Spend $spend
     * @return void
     */
    public function deleted(Spend $spend): void
    {
        WalletPayment::where('spend_id', $spend->spend_id)
            ->delete();
    }
}
