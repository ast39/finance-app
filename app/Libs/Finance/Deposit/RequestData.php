<?php

namespace App\Libs\Finance\Deposit;

use App\Libs\Finance\Exceptions\RequestDataException;
use App\Libs\PlowBack;

/**
 * Объект вклада - запрос
 */
class RequestData {

    # ID вклада
    public ?int $deposit_id;

    # Название вклада
    public string $title;

    # Валюта кредита
    public string $currency;

    # Сумма вклада
    public float  $amount;

    # Процент по вкладу
    public float  $percent;

    # Срок вклада
    public int    $period;

    # Дата открытия вклада
    public int    $start_date;

    # Ежемесячное пополнение
    public float  $refill;

    # Капитализация процентов (Пример: PlowBack::DAILY)
    public int    $capitalization;

    # Будут ли проценты сниматься каждый месяц
    public bool   $withdrawal;

    /**
     * @param string $title
     * @param string $currency
     * @param float $amount
     * @param float $percent
     * @param int $period
     * @param float $refill
     * @param int $capitalization
     * @param bool $withdrawal
     * @param int|null $start_date
     * @param int|null $deposit_id
     * @param string|null $depositor
     * @throws RequestDataException
     */
    public function __construct(
        string  $title,
        string  $currency,
        float   $amount,
        float   $percent,
        int     $period,
        float   $refill,
        int     $capitalization,
        bool    $withdrawal,
        ?int    $start_date = null,
        ?int    $deposit_id = null,
        ?string $depositor  = null,
    )
    {
        $this->title          = $title;
        $this->currency       = $currency;
        $this->amount         = (float) str_replace(',', '.', $amount);
        $this->percent        = (float) str_replace(',', '.', $percent);
        $this->period         = $period;
        $this->refill         = (float) str_replace(',', '.', $refill);
        $this->capitalization = $capitalization;
        $this->withdrawal     = $withdrawal;
        $this->start_date     = $start_date ?: time();
        $this->deposit_id     = $deposit_id ?: null;
        $this->depositor      = $depositor  ?: null;

        $this->validate();
    }

    /**
     * @return void
     * @throws RequestDataException
     */
    private function validate()
    {
        if ($this->amount < 0) {
            throw new RequestDataException('Условия вклада невыполнимы. Сумма вклада 0 или меньше.', 901);
        }

        if ($this->percent < 0) {
            throw new RequestDataException('Условия вклада невыполнимы. Процент по вкладу 0 или ниже.', 902);
        }

        if ($this->period < 0) {
            throw new RequestDataException('Условия вклада невыполнимы. Срок вклада 0 или меньше.', 903);
        }

        if ($this->refill < 0) {
            throw new RequestDataException('Условия вклада невыполнимы. Пополнение 0 или меньше.', 906);
        }

        if (!PlowBack::enum($this->capitalization)) {
            throw new RequestDataException('Условия вклада невыполнимы. Капитализация задана неверно.', 907);
        }
    }
}
