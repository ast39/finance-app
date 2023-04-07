<?php

namespace App\Libs\Finance\Deposit;

/**
 * Объект вклада - ответ
 */
class ResponseData {

    # Объект запроса на вклад
    public  RequestData $deposit;

    # Общая сумма пополнений
    public float $refills;

    # Общая сумма заработанных процентов
    public float $profit;

    # Общая снятая сумма до завершения вклада
    public float $was_withdrawn;

    # Итоговая сумма к снятию
    public float $to_withdraw;

    # Детализация вклада
    public array $details;

    /**
     * @param RequestData $deposit
     * @param float $profit
     * @param array $details
     */
    public function __construct(
        RequestData $deposit,
        float       $profit,
        array       $details,
    )
    {
        $this->deposit       = $deposit;
        $this->refills       = round($deposit->refill * ($deposit->period - 1), 2);
        $this->profit        = round($profit, 2);
        $this->was_withdrawn = (float) end($details)['was_withdrawn'];
        $this->to_withdraw   = (float) end($details)['withdrawal_now'];
        $this->details       = $details;
    }
}
