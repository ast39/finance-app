<?php

namespace App\Http\Mutators;

use App\Libs\Finance\Fraud\ResponseData;
use App\Libs\Finance\Fraud\FraudManager;
use App\Models\Credit\CreditCheck;

class CreditCheckMutator {

    /**
     * @param CreditCheck $credit
     * @return ResponseData|string
     */
    public function __invoke(CreditCheck $credit): ResponseData|string
    {
        $credit = FraudManager::setCredit(
            $credit->title,
            $credit->currency,
            $credit->amount,
            $credit->percent,
            $credit->period,
            $credit->payment,
        );

        return (new FraudManager())->check($credit);
    }
}
