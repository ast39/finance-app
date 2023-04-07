<?php

namespace App\Libs\Time;

use App\Libs\Time\Traits\TimeTrait;

/**
 * Фасад работы со временем
 */
class TimeManager {

    use TimeTrait;

    /**
     * Секунд в сутках
     */
    const DAY = 86400;

    /**
     * Оперирование днями
     *
     * @param int $time
     * @param int $count
     * @return int
     */
    public static function shiftDay(int $time, int $count = 1): int
    {
        $iterator = 1;

        while ($iterator <= abs($count)) {

            $count > 0
                ? $time += self::DAY
                : $time -= self::DAY;

            $iterator++;
        }

        return $time;
    }

    /**
     * Оперирование неделями
     *
     * @param int $time
     * @param int $count
     * @return int
     */
    public static function shiftWeek(int $time, int $count = 1): int
    {
        $iterator = 1;

        while ($iterator <= abs($count)) {

            $count > 0
                ? $time += self::DAY * 7
                : $time -= self::DAY * 7;

            $iterator++;
        }

        return $time;
    }

    /**
     * Оперирование месяцами
     *
     * @param int $time
     * @param int $count
     * @return int
     */
    public static function shiftMonth(int $time, int $count = 1): int
    {
        $iterator = 1;

        while ($iterator <= abs($count)) {

            if ($count > 0) {
                $time += self::DAY * self::daysInMonth($time);

            } else {
                $month = (int) date('m', $time);

                if ($month == 3) {
                    $time -= self::DAY * (self::isLeapYear($time) ? 29 : 28);
                } else {
                    $time -= self::DAY * self::daysInMonth($time);
                }
            }

            $iterator++;
        }

        return $time;
    }

    /**
     * Оперирование годами
     *
     * @param int $time
     * @param int $count
     * @return int
     */
    public static function shiftYear(int $time, int $count = 1): int
    {
        $iterator = 1;

        while ($iterator <= abs($count)) {

            if ($count > 0) {
                $time += self::DAY * self::daysInYear($time);

            } else {

                $month     = (int) date('m', $time);
                $prev_year = (int) date('Y', $time) - 1;

                if ($month > 2 && self::isLeapYear($time)) {
                    $time -= self::DAY * 366;
                } else if ($month <= 2 && self::isLeapYear(strtotime('11-11-' . $prev_year . ' 00:00:00'))) {
                    $time -= self::DAY * 366;
                } else {
                    $time -= self::DAY * 365;
                }
            }

            $iterator++;
        }

        return $time;
    }
}
