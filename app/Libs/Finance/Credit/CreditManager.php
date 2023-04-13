<?php

namespace App\Libs\Finance\Credit;

use App\Libs\Finance\Exceptions\RequestDataException;
use App\Libs\Finance\Exceptions\ResponseDataException;
use App\Libs\Finance\DetailsTrait;
use App\Libs\PaymentType;

/**
 * Фасад кредитов
 */
class CreditManager {

    use DetailsTrait;

    /**
     * Получить объект кредитного запроса
     *
     * @param string $title
     * @param string $currency
     * @param int $payment_type
     * @param int|null $start_date
     * @param int|null $payment_date
     * @param string|null $subject
     * @param float|null $amount
     * @param float|null $percent
     * @param int|null $period
     * @param float|null $payment
     * @param array|null $payments
     * @param int|null $credit_id
     * @return RequestData|string
     */
    public static function setCredit(
        string   $title,
        string   $currency,
        int      $payment_type,
        ?int     $start_date,
        ?int     $payment_date,
        ?string  $subject,
        ?float   $amount,
        ?float   $percent,
        ?int     $period,
        ?float   $payment,
        ?array   $payments,
        ?int     $credit_id = null,
        ?string  $creditor  = null,
    ): RequestData|string
    {
        try {
            return new RequestData($title, $currency, $payment_type, $start_date, $payment_date, $subject, $amount, $percent, $period, $payment, $payments, $credit_id, $creditor);
        } catch (RequestDataException $exception) {
            return $exception->getCode() . ': '. $exception->getMessage();
        }
    }

    /**
     * Рассчитать сумму кредита
     *
     * @param RequestData $credit
     * @return ResponseData|string
     */
    public function findAmount(RequestData $credit): ResponseData|string
    {
        try {
            $creditObj = new Core($credit);

            $credit->amount = $creditObj->getAmount($credit);

            if ($credit->payment_type == PaymentType::DIFFERENCE) {
                $details = $this->monthlyStatementDiff($credit);
            } else {
                $details = $this->monthlyStatement($credit);
            }

            return new ResponseData(
                $credit,
                $details
            );
        } catch (ResponseDataException $exception) {
            return $exception->getCode() . ': '. $exception->getMessage();
        }
    }

    /**
     * Рассчитать процент кредита
     *
     * @param RequestData $credit
     * @return ResponseData|string
     */
    public function findPercent(RequestData $credit): ResponseData|string
    {
        try {
            $creditObj = new Core($credit);

            $credit->percent = $creditObj->getPercent($credit);

            if ($credit->payment_type == PaymentType::DIFFERENCE) {
                $details = $this->monthlyStatementDiff($credit);
            } else {
                $details = $this->monthlyStatement($credit);
            }

            return new ResponseData(
                $credit,
                $details
            );

        } catch (ResponseDataException $exception) {
            return $exception->getCode() . ': '. $exception->getMessage();
        }
    }

    /**
     * Рассчитать срок кредита
     *
     * @param RequestData $credit
     * @return ResponseData|string
     */
    public function findPeriod(RequestData $credit): ResponseData|string
    {
        try {
            $creditObj = new Core($credit);

            $credit->period = $creditObj->getPeriod($credit);

            if ($credit->payment_type == PaymentType::DIFFERENCE) {
                $details = $this->monthlyStatementDiff($credit);
            } else {
                $details = $this->monthlyStatement($credit);
            }

            return new ResponseData(
                $credit,
                $details
            );

        } catch (ResponseDataException $exception) {
            return $exception->getCode() . ': '. $exception->getMessage();
        }
    }

    /**
     * Рассчитать ежемесячный платеж
     *
     * @param RequestData $credit
     * @return ResponseData|string
     * @throws RequestDataException
     */
    public function findPayment(RequestData $credit): ResponseData|string
    {
        try {
            $creditObj = new Core($credit);

            if ($credit->amount <= 0) {
                throw new RequestDataException('Условия кредита невыполнимы. Сумма не может быть 0 и ниже.', 901);
            }

            if ($credit->percent <= 0) {
                throw new RequestDataException('Условия кредита невыполнимы. Процент не может быть 0 и ниже.', 902);
            }

            if ($credit->period <= 0) {
                throw new RequestDataException('Условия кредита невыполнимы. Период не может быть 0 и ниже.', 903);
            }

            if ($credit->payment_type == PaymentType::DIFFERENCE) {

                $credit->payment = round($credit->amount / $credit->period, 2);
                $details         = $this->monthlyStatementDiff($credit);
            } else {

                $credit->payment = $creditObj->getPayment();
                $details         = $this->monthlyStatement($credit);
            }

            return new ResponseData(
                $credit,
                $details
            );

        } catch (ResponseDataException $exception) {
            return $exception->getCode() . ': '. $exception->getMessage();
        }
    }

    /**
     * Вернуть объект кредита
     *
     * @param RequestData $credit
     * @return ResponseData|string
     */
    public function data(RequestData $credit): ResponseData|string
    {
        try {
            $details  = $this->monthlyStatement($credit);

            return new ResponseData(
                $credit,
                $details
            );

        } catch (ResponseDataException $exception) {
            return $exception->getCode() . ': '. $exception->getMessage();
        }
    }
}
