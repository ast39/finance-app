<?php

namespace App\Libs\Finance\Credit;

use App\Libs\CreditSubject;

/**
 * Объект кредита - ответ
 */
class ResponseData {

    # Объект кредитного запроса
    public  RequestData $credit;

    # Сумма процентов по кредиту
    public float $overpay;

    # Сумма тела кредита
    public float $payments;

    # Сумма всех выплат по кредиту
    public float $total_amount;

    # Выплачено по кредиту
    public float $balance_payed;

    # Остаток долга по кредиту
    public float $balance_owed;

    # График платежей по кредиту
    public array $details;


    /**
     * @param RequestData $credit
     * @param array $details
     */
    public function __construct(
        RequestData $credit,
        array $details,
    ) {
        $this->credit = $credit;

        $this->overpay = round(array_sum(array_map(function ($e) {
            return $e['payment_percent'];
        }, $details)), );

        $this->payments = round(array_sum(array_map(function ($e) {
            return $e['payment_body'];
        }, $details)), 2);

        $this->total_amount = round(array_sum(array_map(function ($e) {
            return $e['credit_payment'];
        }, $details)), 2);

        $this->balance_owed = round(array_sum(array_map(function ($e) {
            return $e['date_time'] > time()
                ? $e['payment_body']
                : 0;
        }, $details)), 2);

        $this->balance_payed = round($this->credit->amount - $this->balance_owed, 2);
        $this->details       = $details;

        switch ($this->credit->subject) {

            case CreditSubject::AMOUNT  : $this->credit->amount  = reset($this->details)['inset_balance'] ?? null;
                break;
            case CreditSubject::PERCENT : $this->credit->percent = reset($this->details)['payment_percent'] / $this->credit->amount  * 100 * 12;
                break;
            case CreditSubject::PERIOD  : $this->credit->period  = count($details) ?? null;
                break;
            case CreditSubject::PAYMENT : $this->credit->payment = reset($this->details)['credit_payment'] ?? null;
                break;

            default        :
                break;
        }
    }
}
