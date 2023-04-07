<?php

namespace App\Libs\Time\Traits;

trait TimeTrait {

    /**
     * Проверка на високосный год
     *
     * @param int $time
     * @return bool
     */
    public static function isLeapYear(int $time): bool
    {
        return (int) date('Y', $time) % 4 == 0;
    }

    /**
     * Дней в году по метке времени
     *
     * @param int $time
     * @return int
     */
    public static function daysInYear(int $time): int
    {
        return self::isLeapYear($time)
            ? 366
            : 365;
    }

    /**
     * Дней в месяце по метке времени
     *
     * @param int $time
     * @return int
     */
    public static function daysInMonth(int $time): int
    {
        switch((int) date('m', $time)) {

            case  2 :
                return self::isLeapYear($time)
                    ? 29
                    : 28;
            case  4 :
            case  6 :
            case  9 :
            case 11 :
                return 30;

            default :
                return 31;
        }
    }

}
