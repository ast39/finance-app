<?php

namespace App\Libs\Finance\Deposit;

use App\Libs\PlowBack;

/**
 * Ядро вклада
 */
class Core {

    /**
     * @var RequestData
     */
    protected RequestData $deposit;

    /**
     * @param RequestData $deposit
     */
    public function __construct(RequestData $deposit)
    {
        $this->deposit = $deposit;
    }

    /**
     * Начисление процентов за месяц
     *
     * @param int $year
     * @param int $month
     * @param float $balance
     * @return float
     */
    public function getMonthlyProfit(int $year, int $month, float $balance): float
    {
        return match ($this->deposit->capitalization) {

            PlowBack::DAILY   => $this->monthlyProfitByDay($year, $month, $balance),
            PlowBack::WEEKLY  => $this->monthlyProfitByWeek($month, $balance),
            PlowBack::MONTHLY => $balance * $this->deposit->percent / 100 / 12,

            default => $month % 12 == 0
                    ? $balance * $this->deposit->percent / 100
                    : 0,
        };
    }

    /**
     * Начисление процентов с ежедневной капитализацией
     *
     * @param int $year
     * @param int $month
     * @param float $inset_balance
     * @return float
     */
    public function monthlyProfitByDay(int $year, int $month, float $inset_balance): float
    {
        $profit = 0;

        $days = in_array($month, [1,3,5,7,8,10,12])
            ? 31
            : (in_array($month, [4,6,9,11])
                ? 30
                : ($year%4 == 0
                    ? 29
                    : 28
                )
            );

        $current_balance = $inset_balance;

        for ($i = 0; $i < $days; $i++) {
            $day_profit = $current_balance * $this->deposit->percent / 100 / ($year%4 == 0 ? 366 : 365);

            $profit += $day_profit;
            if ($this->deposit->withdrawal != 1) {
                $current_balance += $day_profit;
            }
        }

        return $profit;
    }

    /**
     * Начисление процентов с еженедельной капитализацией
     *
     * @param int $month
     * @param float $inset_balance
     * @return float
     */
    public function monthlyProfitByWeek(int $month, float $inset_balance): float
    {
        $profit = 0;

        $weeks = $month % 3 == 0
            ? 5 : 4;

        $current_balance = $inset_balance;

        for ($i = 0; $i < $weeks; $i++) {
            $week_profit = $current_balance * $this->deposit->percent / 100 / 52;

            $profit += $week_profit;
            if ($this->deposit->withdrawal != 1) {
                $current_balance += $week_profit;
            }
        }

        return $profit;
    }

    /**
     * Итоговая сумма увеличения вклада за месяц
     *
     * @param float $monthly_profit
     * @param bool $last_month
     * @return float
     */
    public function getMonthlyDeposit(float $monthly_profit, bool $last_month): float
    {
        return
            ($last_month ? 0 : $this->deposit->refill) + (
            $this->deposit->withdrawal == 1
                ? 0
                : $monthly_profit
            );
    }
}
