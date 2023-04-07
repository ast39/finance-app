<?php

namespace App\Libs\Finance\Fraud;

class ResponseData {

    # Credit Request
    public RequestData $credit;

    # Amount info
    public float $real_amount;
    public float $hidden_amount;

    # Percent info
    public float $real_percent;
    public float $hidden_percent;

    # Period info
    public int $real_period;
    public int $hidden_period;

    # Payment info
    public float $real_payment;
    public float $hidden_payment;

    # Overpayments
    public float $total_percent;
    public float $hidden_overpayment;
    public float $total_overpayment;

    # Payments graph
    public array $details;

    /**
     * @param RequestData $credit
     * @param float $amount
     * @param float $percent
     * @param int $period
     * @param float $payment
     * @param float $total_percent
     * @param float $hidden_overpayment
     * @param array $details
     */
    public function __construct(
        RequestData $credit,
        float       $amount,
        float       $percent,
        int         $period,
        float       $payment,
        float       $total_percent,
        float       $hidden_overpayment,
        array       $details,
    )
    {
        $this->credit       = $credit;

        $this->real_amount  = $amount;
        $this->real_percent = $percent;
        $this->real_period  = $period;
        $this->real_payment = $payment;

        $this->hidden_amount   = $amount  - $credit->amount;
        $this->hidden_percent  = $percent - $credit->percent;
        $this->hidden_period   = $credit->period  - $period;
        $this->hidden_payment  = $credit->payment - $payment;

        $this->total_percent       = $total_percent;
        $this->hidden_overpayment  = $hidden_overpayment;
        $this->total_overpayment   = $this->total_percent + $this->hidden_overpayment;

        $this->details         = $details;
    }
}
