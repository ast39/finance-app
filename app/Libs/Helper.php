<?php

namespace App\Libs;

use App\Libs\Time\TimeManager;
use Illuminate\Support\Facades\Storage;

class Helper {

    /**
     * @param int $plow_back
     * @return string
     */
    public static function plowBackText(int $plow_back): string
    {
        return match ($plow_back) {

            PlowBack::YEARLY  => __('Раз в год'),
            PlowBack::MONTHLY => __('Раз в месяц'),
            PlowBack::WEEKLY  => __('Раз в неделю'),
            PlowBack::DAILY   => __('Каждый день'),

            default => 'При закрытии',
        };
    }

    /**
     * @param int $first_payment_date
     * @param int $payments_count
     * @return int
     */
    public static function daysToPayment(int $first_payment_date, int $payments_count): int
    {
        # Время сейчас
        $time         = time();

        # Сегодняшнее число
        $today        = (int) date('d', $time);

        # Число, в которое запланирован регулярный платеж
        $payment_day  = (int) date('d', $first_payment_date);

        # Временная переменная итераций, отражающая время для очередного платежа
        $payment_date = $first_payment_date;

        # Кол-во платежей, которые должны были быть внесены к сегодняшнему число, чтобы не было просрочек
        $payments_must_been = 0;

        # Выполняем, пока прокрутка времени не превысит текущее время
        while($payment_date <= $time) {

            # Если время после прокрутки не превысило текущее время, значит увеличиваем счетчик обязательных платежей
            $payments_must_been++;

            # Прокручиваем время на следующую дату платежа
            $payment_date = TimeManager::shiftMonth($payment_date);
        }

        # Сделаны ли платежи заранее
        $shift = $payments_count - $payments_must_been;

        # Если сегодня день списания и платежа не было - фиксируем это
        if ($shift < 0 && $today == $payment_day) {
            return 0;
        }

        # Если платежей сделано меньше, чем должно было быть, то фиксируем просрочку
        if ($shift < 0) {
            return -1;
        }

        # Определяем дату следующего платежа с учетом заранее сделанных платежей (если они есть)
        $payment_date = TimeManager::shiftMonth($payment_date, $shift);

        # Дней до очередного платежа
        return ceil(($payment_date - $time) / TimeManager::DAY);
    }

    /**
     * @param int $days
     * @return string
     */
    public static function paymentStatus(int $days): string
    {
        if ($days < 0) {
            return 'Просрочен';
        } else if ($days == 0) {
            return 'Списание сегодня';
        } else {
            return $days . self::number($days, [__('день'), __('дня'), __('дней')]);
        }
    }

    /**
     * @param int $n
     * @param array $titles
     * @return string
     */
    public static function number(int $n, array $titles): string
    {
        $cases = [2, 0, 1, 1, 1, 2];

        return ' '. $titles[($n % 100 > 4 && $n % 100 < 20) ? 2 : $cases[min($n % 10, 5)]];
    }

    /**
     * @param int $payment_time
     * @param int $status
     * @return string
     */
    public static function getPaymentIcon(int $payment_time, int $status): string
    {
        switch ($status) {

            case 1  : return Icons::PAYMENT_CHECK;

            default : return $payment_time > time()
                ? Icons::PAYMENT_WAITING
                : Icons::PAYMENT_OVERDUE;
        }
    }

    /**
     * @param int $payment_time
     * @param bool $status
     * @return string
     */
    public static function getPaymentTextColor(int $payment_time, bool $status): string
    {
        switch ($status) {

            case true  : return 'text-success';

            default : return $payment_time > time()
                ? 'text-secondary'
                : 'text-danger';
        }
    }

    /**
     * @param int $months
     * @return string
     */
    public static function creditPeriod(int $months): string
    {
        if ($months < 12) {
            return $months . ' ' . self::number($months, [__('месяц'), __('месяца'), __('месяцев')]);
        }

        $years = floor($months / 12);

        if ($months % 12 == 0) {
            return $years . ' ' . self::number($years, [__('год'), __('года'), __('лет')]);
        }

        $months -= $years * 12;

        return $years . ' ' . self::number($years, [__('год'), __('года'), __('лет')])
            . $months . ' ' . self::number($months, [__('месяц'), __('месяца'), __('месяцев')]);
    }

    /**
     * @return array
     */
    public static function expensesIcons(): array
    {
        return Storage::disk('icons')->files();
    }

    /**
     * Форматированный вывод подсчета данных по ключу массива
     *
     * @param array $data
     * @param string $key
     * @param int $round
     * @return string
     */
    public static function total(array $data, string $key, int $round = 0): string
    {
        return
            number_format(
                array_sum(
                    array_map(function($e) use ($key) {
                        return $e[$key];
                    }, $data)
                ), $round, '.', ' '
            );
    }
}
