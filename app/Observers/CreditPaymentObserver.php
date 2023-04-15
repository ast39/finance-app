<?php

namespace App\Observers;

use App\Models\Credit\CreditPayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CreditPaymentObserver {

    /**
     * @param CreditPayment $payment
     * @return void
     */
    public function saved(CreditPayment $payment): void
    {
        if (Cache::has('wall.' . Auth::id())) {
            Cache::delete('wall.' . Auth::id());
        }
    }

    /**
     * @param CreditPayment $payment
     * @return void
     */
    public function deleted(CreditPayment $payment): void
    {
        if (Cache::has('wall.' . Auth::id())) {
            Cache::delete('wall.' . Auth::id());
        }
    }
}
