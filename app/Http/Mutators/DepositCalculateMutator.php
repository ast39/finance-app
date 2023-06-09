<?php

namespace App\Http\Mutators;

use App\Libs\Finance\Deposit\ResponseData;
use App\Libs\Finance\Deposit\DepositManager;
use App\Models\Deposit\Deposit;
use App\Models\Deposit\DepositCalculate;

class DepositCalculateMutator {

    /**
     * @param DepositCalculate|Deposit $deposit
     * @return ResponseData|string
     */
    public function __invoke(DepositCalculate|Deposit $deposit): ResponseData|string
    {
        $deposit = DepositManager::setDeposit(
            $deposit->title,
            $deposit->currency,
            $deposit->amount,
            $deposit->percent,
            $deposit->period,
            $deposit->refill,
            $deposit->capitalization,
            $deposit->withdrawal,
            $deposit->start_date,
            $deposit->deposit_id ?? null,
        );

        return (new DepositManager())->calculate($deposit);
    }
}
