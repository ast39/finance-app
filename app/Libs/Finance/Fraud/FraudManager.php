<?php

namespace App\Libs\Finance\Fraud;

use App\Libs\Finance\Exceptions\RequestDataException;
use App\Libs\Finance\Exceptions\ResponseDataException;

/**
 * Фасад проверки на фрод
 */
class FraudManager {

    /**
     * @param string $title
     * @param string $currency
     * @param float $amount
     * @param float $percent
     * @param int $period
     * @param float $payment
     * @return RequestData|string
     */
    public static function setCredit(
        string $title,
        string $currency,
        float  $amount,
        float  $percent,
        int    $period,
        float  $payment,
    ): RequestData|string
    {
        try {
            return new RequestData($title, $currency, $amount, $percent, $period, $payment);
        } catch (RequestDataException $exception) {
            return $exception->getCode() . ': '. $exception->getMessage();
        }
    }

    /**
     * @param RequestData $credit
     * @return ResponseData|string
     */
    public function check(RequestData $credit): ResponseData|string
    {
        try {
            $creditObj = new Core($credit);

            $real_amount  = $creditObj->findAmount($credit->percent, $credit->period,  $credit->payment);
            $real_percent = $creditObj->findPercent($credit->amount, $credit->period,  $credit->payment);
            $real_period  = $creditObj->findPeriod($credit->amount,  $credit->percent, $credit->payment);
            $real_payment = $creditObj->findPayment($credit->amount, $credit->percent, $credit->period);

            $details = $creditObj->details($real_percent);

            $percent_payed = array_sum(array_map(function ($e) {
                return $e['percent'];
            }, $details));

            return new ResponseData(
                $credit,
                $real_amount,
                $real_percent,
                $real_period,
                $real_payment,
                $percent_payed,
                $credit->payment * $credit->period - $real_payment * $credit->period,
                $details
            );
        } catch (ResponseDataException $exception) {
            return $exception->getCode() . ': '. $exception->getMessage();
        }
    }
}
