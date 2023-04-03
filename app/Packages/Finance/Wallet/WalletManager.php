<?php

namespace App\Packages\Finance\Wallet;

use App\Models\Wallet\Wallet;
use App\Packages\Finance\Exceptions\ResponseDataException;

/**
 * Фасад сейфов
 */
class WalletManager {

    public static function calculate(Wallet $wallet): WalletResponseData|string
    {
        try {
            $safeObj = new WalletInstance($wallet);

            $details = $safeObj->history();

            return new WalletResponseData(
                $wallet,
                $details
            );
        } catch (ResponseDataException $exception) {
            return $exception->getCode() . ': '. $exception->getMessage();
        }
    }
}
