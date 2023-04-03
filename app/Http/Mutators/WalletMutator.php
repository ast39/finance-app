<?php

namespace App\Http\Mutators;

use App\Http\Resources\Wallet\WalletResource;
use App\Models\Wallet\Wallet;
use Illuminate\Support\Arr;

class WalletMutator {

    /**
     * @param array|Wallet|WalletResource $wallet
     * @return array
     */
    public function __invoke(array|Wallet|WalletResource $wallet): array
    {
        if ($wallet instanceof Wallet) {
            $wallet = $wallet->toArray();
        }

        $wallet['payments'] = $this->history($wallet);

        return $this->calculate($wallet);
    }

    /**
     * @param array $wallet
     * @return array
     */
    private function history(array $wallet): array
    {
        $details = [];

        $balance = $wallet['amount'];

        foreach ($wallet['payments'] as $payment) {

            if ($payment['status'] == config('statuses.off')) {
                continue;
            }

            $details[] = [

                'payment_id'         => $payment['payment_id'],
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

    /**
     * @param array $wallet
     * @return array
     */
    private function calculate(array $wallet): array
    {
        $wallet['count_deposits']    = count(Arr::where($wallet['payments'], function ($e) {
            return $e['transaction_amount'] > 0;
        }));

        $wallet['total_deposits']    = round(array_sum(Arr::map($wallet['payments'], function ($e) {
            return max($e['transaction_amount'], 0);
        })));

        $wallet['count_withdrawals'] = count(Arr::where($wallet['payments'], function ($e) {
            return $e['transaction_amount'] < 0;
        }));

        $wallet['total_withdrawals'] =round(array_sum(Arr::map($wallet['payments'], function ($e) {
            return min($e['transaction_amount'], 0);
        })));

        $wallet['total_transactions'] = $wallet['total_deposits'] + $wallet['total_withdrawals'];
        $wallet['count_transactions'] = $wallet['count_deposits'] + $wallet['count_withdrawals'];

        $wallet['balance'] = round($wallet['amount'] + $wallet['total_deposits'] + $wallet['total_withdrawals'], 2);

        return $wallet;
    }
}
