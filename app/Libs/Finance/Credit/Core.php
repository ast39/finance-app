<?php

namespace App\Libs\Finance\Credit;

use App\Libs\Finance\Exceptions\ResponseDataException;

/**
 * Ядро кредита
 */
class Core {

    /**
     * Экземпляр кредитного запроса
     *
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
     * Найти сумму кредита
     *
     * @param RequestData $credit
     * @return float
     * @throws ResponseDataException
     */
    public function getAmount(RequestData $credit): float
    {
        $step           = 10000;
        $credit_amount  = 1;
        $credit_payment_min = $credit->payment - ($credit->payment * 0.0001);
        $credit_payment_max = $credit->payment + ($credit->payment * 0.0001);

        do {
            $payment = $this->findPayment($credit_amount, $credit->percent, $credit->period);

            if ($payment > $credit->payment && $credit_amount == 1) {
                throw new ResponseDataException('Условия кредита невыполнимы. Сумма кредита 0 или меньше.', 909);
            }

            if ($payment < $credit->payment) {
                $credit_amount = $credit_amount + $step;
            }

            if ($payment > $credit->payment) {

                $credit_amount = $credit_amount - $step;
                $step = $step / 10;
                $credit_amount = $credit_amount + $step;
            }

        } while ($payment < $credit_payment_min || $payment > $credit_payment_max);

        return $credit_amount;
    }

    /**
     * Найти процент
     * @param RequestData $credit
     * @return float
     * @throws ResponseDataException
     */
    public function getPercent(RequestData $credit): float
    {
        $step           = 10;
        $credit_percent = 0.1;
        $credit_payment_min = $credit->payment - ($credit->payment * 0.0001);
        $credit_payment_max = $credit->payment + ($credit->payment * 0.0001);

        do {
            $payment = $this->findPayment($credit->amount, $credit_percent, $credit->period);

            if ($payment > $credit->payment && $credit_percent == 0.1) {
                throw new ResponseDataException('Условия кредита невыполнимы, процент 0 или ниже.', 908);
            }

            if ($payment < $credit->payment) {
                $credit_percent = $credit_percent + $step;
            }

            if ($payment > $credit->payment) {

                $credit_percent = $credit_percent - $step;
                $step = $step / 10;
                $credit_percent = $credit_percent + $step;
            }

        } while ($payment < $credit_payment_min || $payment > $credit_payment_max);

        return $credit_percent;
    }

    /**
     * Найти срок кредита
     *
     * @param RequestData $credit
     * @return int
     */
    public function getPeriod(RequestData $credit): int
    {
        $period = 0;

        $inset_balance = $credit->amount;
        $payment       = $credit->payment;

        do {

            $current_percent = ceil($inset_balance * $credit->percent / 12 / 100);
            $current_body    = $payment - $current_percent;
            $outset_balance  = $inset_balance - $current_body;

            if ($outset_balance < 0) {

                $difference      = abs($outset_balance);
                $payment        -= $difference;
                $outset_balance  = 0;
            }

            if ($outset_balance < ($credit->payment / 10)) {

                $payment       += $outset_balance;
                $outset_balance = 0;
            }

            $inset_balance = $outset_balance;
            $period++;

        } while ($outset_balance > 0);

        return $period;
    }

    /**
     * Найти ежемесячный платеж
     *
     * @return float
     * @throws ResponseDataException
     */
    public function getPayment(): float
    {
        $monthly_percent = $this->credit->percent / 12 / 100;

        $part_1 = $monthly_percent * pow(1 + $monthly_percent, $this->credit->period);
        $part_2 = pow(1 + $monthly_percent, $this->credit->period) - 1;

        if ($part_2 == 0) {
            throw new ResponseDataException('Условия кредита невыполнимы. Деление на 0.', 911);
        }

        return ceil($this->credit->amount * ($part_1 / $part_2));
    }


    /**
     * Найти платеж по сумме, проценту и сроку
     *
     * @param float $credit_amount
     * @param float $credit_percent
     * @param int $credit_period
     * @return float
     */
    private function findPayment(float $credit_amount, float $credit_percent, int $credit_period): float
    {
        $monthly_percent = $credit_percent / 12 / 100;

        $part_1 = $monthly_percent * pow(1 + $monthly_percent, $credit_period);
        $part_2 = pow(1 + $monthly_percent, $credit_period) - 1;

        if ($part_2 == 0) {
            return 0;
        }

        return ceil($credit_amount * ($part_1 / $part_2));
    }
}
