<?php

namespace App\Libs;

class Icons {

    const USER          = 'bi bi-person';                 // пользователь
    const CHECK_UP      = 'bi bi-arrow-bar-up';           // меню - расчет вклада
    const CHECK_DOWN    = 'bi bi-arrow-bar-down';         // меню - расчет кредита
    const CHECK         = 'bi bi-check2-all';             // меню - проверка кредита

    const WALLET        = 'bi bi-wallet2';                // меню - кошелек / кошелек
    const CREDITS       = 'bi bi-calculator';             // меню кредиты
    const DEPOSITS      = 'bi bi-box-arrow-in-down';      // меню - вклады
    const SPEND         = 'bi bi-cart-dash';              // меню - расходы
    const CATEGORY      = 'bi bi-tag';                    // меню - категории / категория
    const LOGOUT        = 'bi bi-box-arrow-right';        // меню - выход

    const SEARCH        = 'bi bi-search';                 // поиск
    const RESET         = 'bi bi-arrow-counterclockwise'; // откат назад
    const RETURN        = 'bi bi-arrow-return-left';      // назад
    const CREATE        = 'bi bi-folder-plus';            // добавить
    const SAVE          = 'bi bi-cloud-arrow-up';         // сохранить
    const EDIT          = 'bi bi-pencil-square';          // изменить
    const DELETE        = 'bi bi-trash';                  // удалить
    const CALCULATE     = 'bi bi-calculator';             // рассчитать
    const PLUS          = 'bi bi-plus-lg';                // плюс

    const TITLE         = 'bi bi-text-indent-left';       // заголовок
    const BANK          = 'bi bi-bank';                   // банк
    const LIST          = 'bi bi-list-ul';                // список
    const CHECK_LIST    = 'bi bi-card-checklist';         // чек лист
    const CALENDAR_DAY  = 'bi bi-calendar2-date';         // дата календаря
    const CALENDAR      = 'bi bi-calendar3';              // общий календарь
    const CURRENCY      = 'bi bi-currency-exchange';      // валюта
    const NOTE          = 'bi bi-card-text';              // записки
    const PROFIT_UP     = 'bi bi-bar-chart';              // профит
    const QUESTION      = 'bi bi-question-circle';        // вопрос
    const TOOLS         = 'bi bi-tools';                  // инструменты
    const PERCENT       = 'bi bi-percent';                // процент
    const PERIOD        = 'bi bi-clock-history';          // период
    const AMOUNT        = 'bi bi-collection';             // пачка купюр
    const BALANCE_START = 'bi bi-cash';                   // 1 денежка
    const BALANCE       = 'bi bi-cash-stack';             // пачка денежек
    const BALANCE_CASH  = 'bi bi-cash-coin';              // денежка с монеткой
    const TRANSACTIONS  = 'bi bi-arrow-down-up';          // транзакции

    const PROFIT        = 'bi bi-chevron-double-up';      // рост
    const LOSS          = 'bi bi-chevron-double-down';    // упадок

    const SMILE_HAPPY   = 'bi bi-emoji-smile';            // счастливый смайлик
    const SMILE_NEUTRAL = 'bi bi-emoji-neutral';          // нейтральный смайлик
    const SMILE_SAD     = 'bi bi-emoji-frown';            // грустный смайлик

    const INSET_UD      = 'bi bi-box-arrow-in-down';      // в коробку сверху
    const OUTSET_UD     = 'bi bi-box-arrow-down';         // из коробки сверху
    const INSET_DU      = 'bi bi-box-arrow-in-up';        // в коробку снизу
    const OUTSET_DU     = 'bi bi-box-arrow-up';           // из коробки снизу
    const INSET_LR      = 'bi bi-box-arrow-in-right';     // в коробку слева
    const OUTSET_LR     = 'bi bi-box-arrow-right';        // из коробки слева
    const INSET_COUNT   = 'bi bi-caret-down';             // треугольник вниз
    const OUTSET_COUNT  = 'bi bi-caret-up';               // треугольник вверх

    const PAYMENT_CHECK   = 'bi bi-check2-square';        // платеж внесен
    const PAYMENT_OVERDUE = 'bi bi-exclamation-triangle'; // платеж просрочен
    const PAYMENT_WAITING = 'bi bi-stopwatch';            // в ожидании платежа

    const TYPE           = 'bi bi-list';
    const BALANCE_UP     = 'bi bi-box-arrow-in-down';
    const BALANCE_DOWN   = 'bi bi-box-arrow-up';
    const PAYMENT        = 'bi bi-cash-stack';
    const WAS_PAYED      = 'bi-hourglass-split';
    const WILL_PAY       = 'bi bi-hourglass-bottom';



    /**
     * @param string $class
     * @return string
     */
    public static function get(string $class): string
    {
        return '<i class="' . $class . '"></i>';
    }

}
