<?php

namespace App\Packages\Finance\Wallet;

use App\Models\Wallet\Wallet;

class WalletInstance {

    /**
     * Экземпляр кошелька
     *
     * @var Wallet
     */
    protected Wallet $wallet;

    /**
     * @param Wallet $wallet
     */
    public function __construct(Wallet $wallet)
    {
        $this->wallet = $wallet;
    }

    public function history()
    {
        $details = [];

        $balance = $this->wallet->amount;

        foreach ($this->wallet->payments as $payment) {

            $details[] = [
                'date_time'          => $payment['created_at'],
                'inset_balance'      => $balance,
                'transaction_amount' => $payment['amount'],
                'outset_balance'     => $balance + $payment['amount'],
                'note'               => $payment['note'],
            ];

            $balance += $payment['amount'];
        }

        return $details;
    }
}
