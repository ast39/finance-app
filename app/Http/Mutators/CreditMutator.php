<?php

namespace App\Http\Mutators;

use App\Libs\Finance\Credit\CreditManager;
use App\Libs\Finance\Credit\ResponseData;
use App\Libs\Finance\Exceptions\RequestDataException;
use App\Libs\PaymentType;
use App\Models\Credit\Credit;

class CreditMutator {

    /**
     * @param Credit $credit
     * @return ResponseData|string
     * @throws RequestDataException
     */
    public function __invoke(Credit $credit): ResponseData|string
    {
        $credit = CreditManager::setCredit(
            $credit->title,
            $credit->currency,
            PaymentType::ANNUITANT,
            $credit->start_date,
            $credit->payment_date,
            $credit->subject,
            $credit->amount,
            $credit->percent,
            $credit->period,
            $credit->payment,
            $credit->payments->toArray(),
            $credit->credit_id ?? null,
            $credit->creditor ?? null,
        );

        return (new CreditManager())->data($credit);
    }
}
