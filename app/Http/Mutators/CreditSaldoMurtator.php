<?php

namespace App\Http\Mutators;

class CreditSaldoMurtator {

    public function __invoke(array $credits): array
    {
        $saldo = [];

        foreach ($credits as $credit) {
            if (!key_exists($credit->credit->currency, $saldo)) {
                $saldo[$credit->credit->currency] = [];
            }

            $saldo[$credit->credit->currency][] = $credit;
        }

        foreach ($saldo as $currency => $data) {
            $saldo[$currency]['count']    = count($data);
            $saldo[$currency]['amount']   = array_sum(array_map(function($e) {return $e->credit->amount;}, $data));
            $saldo[$currency]['payed']    = array_sum(array_map(function($e) {return $e->balance_payed;}, $data));
            $saldo[$currency]['debt']     = array_sum(array_map(function($e) {return $e->balance_owed;}, $data));
            $saldo[$currency]['payments'] = array_sum(array_map(function($e) {return $e->credit->payment;}, $data));
        }

        return $saldo;
    }
}
