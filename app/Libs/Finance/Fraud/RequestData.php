<?php

namespace App\Libs\Finance\Fraud;

use App\Libs\Finance\Exceptions\RequestDataException;

class RequestData {

    # Название
    public string $title;

    # Валюта
    public string $currency;

    # Сумма
    public float  $amount;

    # Процент
    public float  $percent;

    # Срок
    public int    $period;

    # Ежемесячный платеж
    public float  $payment;

    /**
     * @param string $title
     * @param string $currency
     * @param float $amount
     * @param float $percent
     * @param int $period
     * @param float $payment
     * @throws RequestDataException
     */
    public function __construct(
        string $title,
        string $currency,
        float  $amount,
        float  $percent,
        int    $period,
        float  $payment
    ) {
        $this->title    = $title;
        $this->currency = $currency;
        $this->amount   = (float) str_replace(',', '.', $amount);
        $this->percent  = (float) str_replace(',', '.', $percent);
        $this->period   = $period;
        $this->payment  = (float) str_replace(',', '.', $payment);

        $this->validate();
    }

    /**
     * @return void
     * @throws RequestDataException
     */
    private function validate()
    {
        if ($this->amount < 0) {
            throw new RequestDataException('Условия кредита невыполнимы. Сумма кредита 0 или меньше.', 901);
        }

        if ($this->percent < 0) {
            throw new RequestDataException('Условия кредита невыполнимы. Процент по кредиту 0 или ниже.', 902);
        }

        if ($this->period < 0) {
            throw new RequestDataException('Условия кредита невыполнимы. Срок кредита 0 или меньше.', 903);
        }

        if ($this->payment < 0) {
            throw new RequestDataException('Условия кредита невыполнимы. Платеж по кредиту 0 или меньше.', 904);
        }

        if ($this->payment >= $this->amount) {
            throw new RequestDataException('Условия кредита невыполнимы. Сумма кредита меньше платежа.', 905);
        }
    }
}
