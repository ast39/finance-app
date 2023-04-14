<?php

namespace App\Libs\Finance;

use App\Libs\Finance\Credit\RequestData;

/**
 * Трейт для детализации кредита
 */
trait DetailsTrait {

    /**
     * Месячная детализация с аннуитетным платежом
     *
     * @param RequestData $credit
     * @return array
     */
    protected function monthlyStatement(
        RequestData $credit
    ): array
    {
        $details  = [];

        $inset_balance        = $credit->amount;
        $old_payment_date     = $credit->start_date;
        $current_payment_date = $credit->payment_date;

        $monthly_payment = $credit->payment;

        for ($i = 1; $i <= $credit->period; $i++) {

            $current_percent = ceil($this->getPercentByPeriod($old_payment_date, $current_payment_date, $inset_balance, $credit->percent));
            $current_body    = $monthly_payment - $current_percent;
            $outset_balance  = $inset_balance - $current_body;

            if ($outset_balance < 0) {

                $difference       = abs($outset_balance);
                $monthly_payment -= $difference;
                $current_body    -= $difference;
                $outset_balance   = 0;
            }

            if ($i == $credit->period && $outset_balance > 0) {

                $monthly_payment += $outset_balance;
                $current_body    += $outset_balance;
                $outset_balance   = 0;
            }

            $details[$i] = [

                'date_time'       => $current_payment_date,
                'inset_balance'   => $inset_balance,
                'credit_payment'  => $monthly_payment,
                'payment_percent' => $current_percent,
                'payment_body'    => $current_body,
                'outset_balance'  => $outset_balance,
                'note'            => $credit->payments[$i - 1]['note'] ?? '',
                'status'          => count($credit->payments) >= $i,
            ];

            $inset_balance = $outset_balance;

            $old_payment_date     = $current_payment_date;
            $current_payment_date = $this->plusMonth($current_payment_date);
        }

        return $details;
    }

    /**
     * Месячная детализация с дифференцированным платежом
     *
     * @param RequestData $credit
     * @return array
     */
    protected function monthlyStatementDiff(
        RequestData $credit
    ): array
    {
        $details  = [];
        $overpay  = 0;
        $payments = 0;

        $inset_balance        = $credit->amount;
        $old_payment_date     = $credit->start_date;
        $current_payment_date = $credit->payment_date;
        $payment_body         = round($credit->amount / $credit->period, 2);

        for ($i = 1; $i <= $credit->period; $i++) {

            $current_body    = $payment_body;
            $current_percent = ceil($this->getPercentByPeriod($old_payment_date, $current_payment_date, $inset_balance, $credit->percent));
            $current_payment = $payment_body + $current_percent;
            $outset_balance  = $inset_balance - $payment_body;

            if ($outset_balance < 0) {

                $difference       = abs($outset_balance);
                $credit->payment -= $difference;
                $current_body    -= $difference;
                $outset_balance   = 0;
            }

            if ($i == $credit->period && $outset_balance > 0) {

                $credit->payment += $outset_balance;
                $current_body    += $outset_balance;
                $outset_balance   = 0;
            }

            $details[$i] = [

                'date_time'       => $current_payment_date,
                'inset_balance'   => $inset_balance,
                'credit_payment'  => $current_payment,
                'payment_percent' => $current_percent,
                'payment_body'    => $current_body,
                'outset_balance'  => $outset_balance,
                'status'          => count($credit->payments) >= $i,
            ];

            $overpay      += $current_percent;
            $payments     += $credit->payment;
            $inset_balance = $outset_balance;

            $old_payment_date     = $current_payment_date;
            $current_payment_date = $this->plusMonth($current_payment_date);
        }

        return $details;
    }


    /**
     * Получить месяц для платежа по номеру
     *
     * @param int $start_date
     * @param int $payment_num
     * @return int
     */
    protected function getMonth(int $start_date, int $payment_num): int
    {
        $new_date = $start_date;
        for ($i = 1; $i <= $payment_num; $i++) {
            $new_date = $this->plusMonth($new_date);
        }

        return $new_date;
    }

    /**
     * Добавить месяц к дате
     *
     * @param int $time
     * @return int
     */
    protected function plusMonth(int $time): int
    {
        $year  = (int) date('Y', $time);
        $month = (int) date('m', $time);
        $day   = (int) date('d', $time);

        $month = $month == 12 ? 1 : $month + 1;
        $year  = $month == 1  ? $year + 1 : $year;

        $day = match ($month) {

            2           => $year%4 == 0 ? (min($day, 29)) : (min($day, 28)),
            4, 6, 11, 9 => min($day, 30),

            default     => $day,
        };

        return strtotime(
            str_pad($day, 2, 0, STR_PAD_LEFT) . '-'
            . str_pad($month, 2, 0, STR_PAD_LEFT). '-'
            . str_pad($year, 4, 0, STR_PAD_LEFT) . ' 09:00:00'
        );
    }

    /**
     * Дней в текущем году
     *
     * @param int $pay_date
     * @return int
     */
    protected function daysInYear(int $pay_date): int
    {
        return date('Y', $pay_date) % 4 == 0 ? 366 : 365;

    }

    /**
     * Сумма процентоа между 2мя датами
     *
     * @param int $from
     * @param int $to
     * @param int $mount
     * @param float $percent
     * @return float
     */
    protected function getPercentByPeriod(int $from, int $to, int $mount, float $percent): float
    {
        $seconds_in_day = 3600 * 24;
        $percent_amount = 0;

        do {
            $percent_amount += $mount * $percent / 100 / $this->daysInYear($from);
            $from += $seconds_in_day;

        } while($from < $to);

        return $percent_amount;
    }

}
