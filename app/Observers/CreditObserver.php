<?php

namespace App\Observers;

use App\Models\Credit\Credit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CreditObserver {

    /**
     * @param Credit $credit
     * @return void
     */
    public function saved(Credit $credit): void
    {
        if (Cache::has('wall.' . Auth::id())) {
            Cache::delete('wall.' . Auth::id());
        }
    }

    /**
     * @param Credit $credit
     * @return void
     */
    public function deleted(Credit $credit): void
    {
        if (Cache::has('wall.' . Auth::id())) {
            Cache::delete('wall.' . Auth::id());
        }
    }
}
