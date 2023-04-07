<?php

namespace App\Http\Libs;

/**
 * Plow back format object
 */
class PlowBack {

    const DAILY   = 1;
    const WEEKLY  = 7;
    const MONTHLY = 30;
    const YEARLY  = 360;
    const WITHOUT = 0;

    /**
     * Check capitalization value format
     *
     * @param int $value
     * @return bool
     */
    public static function enum(int $value): bool
    {
        $oClass = new \ReflectionClass(__CLASS__);

        return in_array($value, $oClass->getConstants());
    }
}
