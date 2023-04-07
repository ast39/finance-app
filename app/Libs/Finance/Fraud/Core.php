<?php

namespace App\Libs\Finance\Fraud;

use App\Libs\Finance\Exceptions\ResponseDataException;

class Core {

    /**
     * @var RequestData
     */
    protected RequestData $credit;

    /**
     * @param RequestData $credit
     */
    public function __construct(RequestData $credit)
    {
        $this->credit = $credit;
    }

    /**
     * Найти реальную сумму
     *
     * @param float $credit_percent
     * @param int $credit_period
     * @param float $credit_payment
     * @return float
     * @throws ResponseDataException
     */
    public function findAmount(float $credit_percent, int $credit_period, float $credit_payment): float
    {
        $monthly_percent = $credit_percent / 12 / 100;

        $part_1 = $monthly_percent * pow(1 + $monthly_percent, $credit_period);
        $part_2 = pow(1 + $monthly_percent, $credit_period) - 1;

        if ($part_2 == 0) {
            throw new ResponseDataException('Division to zero', 911);
        }

        return ceil($credit_payment / ($part_1 / $part_2));
    }

    /**
     * Найти реальный процент
     *
     * @param float $credit_amount
     * @param int $credit_period
     * @param float $credit_payment
     * @return float
     * @throws ResponseDataException
     */
    public function findPercent(float $credit_amount, int $credit_period, float $credit_payment): float
    {
        $step           = 10;
        $credit_percent = 10;
        $credit_payment_min = $credit_payment - ($credit_payment * 0.0001);
        $credit_payment_max = $credit_payment + ($credit_payment * 0.0001);

        do {
            $payment = $this->findPayment($credit_amount, $credit_percent, $credit_period);

            if ($payment < $credit_payment) {
                $credit_percent = $credit_percent + $step;
            }

            if ($payment > $credit_payment) {

                $credit_percent = $credit_percent - $step;
                $step = $step / 10;
                $credit_percent = $credit_percent + $step;
            }

        } while ($payment < $credit_payment_min || $payment > $credit_payment_max);

        return $credit_percent;
    }

    /**
     * Найти реальный ежемесячный платеж
     *
     * @param float $credit_amount
     * @param float $credit_percent
     * @param int $credit_period
     * @return float
     * @throws ResponseDataException
     */
    public function findPayment(float $credit_amount, float $credit_percent, int $credit_period): float
    {
        $monthly_percent = $credit_percent / 12 / 100;

        $part_1 = $monthly_percent * pow(1 + $monthly_percent, $credit_period);
        $part_2 = pow(1 + $monthly_percent, $credit_period) - 1;

        if ($part_2 == 0) {
            throw new ResponseDataException('Division to zero', 911);
        }

        return ceil($credit_amount * ($part_1 / $part_2));
    }

    /**
     * Найти реальный срок
     *
     * @param float $credit_amount
     * @param float $credit_percent
     * @param float $credit_payment
     * @return int
     */
    public function findPeriod(float $credit_amount, float $credit_percent, float $credit_payment): int
    {
        $months       = 0;
        $inset_balance = $credit_amount;

        do {

            $monthly_inset_balance   = ceil($inset_balance);
            $monthly_percent_amount  = ceil($inset_balance  * $credit_percent / 12 / 100);
            $monthly_body_amount     = ceil($credit_payment - $monthly_percent_amount);
            $monthly_outset_balance  = ceil($monthly_inset_balance  - $monthly_body_amount);

            $inset_balance = $monthly_outset_balance;
            $months++;

        } while ($monthly_outset_balance > 0);

        return $months;
    }

    /**
     * Детализация
     *
     * @param float $real_percent
     * @return array
     */
    public function details(float $real_percent): array
    {
        $details = [];
        $inset   = $this->credit->amount;

        for ($month = 1; $month <= $this->credit->period; $month++) {

            if ($inset == 0) {
                break;
            }

            $monthly_details = [

                'inset'   => ceil($inset),
                'percent' => ceil($inset  * $real_percent / 12 / 100),
            ];

            $monthly_details['body']    = ceil($this->credit->payment      - $monthly_details['percent']);
            $monthly_details['payment'] = ceil($monthly_details['percent'] + $monthly_details['body']);
            $monthly_details['outset']  = ceil($monthly_details['inset']   - $monthly_details['body']);

            if ($monthly_details['outset'] < 0 || ($month == $this->credit->period && $monthly_details['outset'] > 0)) {

                $monthly_details['body']    = $monthly_details['body']    + $monthly_details['outset'];
                $monthly_details['payment'] = $monthly_details['payment'] + $monthly_details['outset'];
                $monthly_details['outset']  = 0;
            }

            $inset = $monthly_details['outset'];

            $details[] = $monthly_details;
        }

        return $details;
    }
}
