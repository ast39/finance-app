<?php

namespace App\Libs;

class Icons {

    const TITLE         = 'bi bi-text-indent-left';   // заголовок
    const LIST          = 'bi bi-list-ul';            // список
    const CATEGORY      = 'bi bi-tag';                // категория
    const CURRENCY      = 'bi bi-currency-exchange';  // валюты
    const NOTE          = 'bi bi-card-text';          // записки
    const SEARCH        = 'bi bi-search';             // поиск
    const TOOLS         = 'bi bi-tools';              // инструменты
    const RESET         = 'bi bi-arrow-counterclockwise'; // откат назад
    const BALANCE_START = 'bi bi-cash';               // 1 денежка
    const BALANCE       = 'bi bi-cash-stack';         // пачка денежек
    const BALANCE_CASH  = 'bi bi-cash-coin';          // денежка с монеткой
    const TRANSACTIONS  = 'bi bi-arrow-down-up';      // транзакции
    const WALLET        = 'bi bi-wallet2';            // кошелек
    const INSET_UD      = 'bi bi-box-arrow-in-down';  // в коробку сверху
    const OUTSET_UD     = 'bi bi-box-arrow-down';     // из коробки сверху
    const INSET_DU      = 'bi bi-box-arrow-in-up';    // в коробку снизу
    const OUTSET_DU     = 'bi bi-box-arrow-up';       // из коробки снизу
    const INSET_LR      = 'bi bi-box-arrow-in-right'; // в коробку слева
    const OUTSET_LR     = 'bi bi-box-arrow-right';    // из коробки слева
    const INSET_COUNT   = 'bi bi-caret-down';         // треугольник вниз
    const PROFIT        = 'bi bi-chevron-double-up';  // рост
    const LOSS          = 'bi bi-chevron-double-down'; // упадок
    const OUTSET_COUNT  = 'bi bi-caret-up';           // треугольник вверх
    const RETURN        = 'bi bi-arrow-return-left';  // назад
    const CREATE        = 'bi bi-folder-plus';        // добавить
    const SAVE          = 'bi bi-cloud-arrow-up';     // сохранить
    const EDIT          = 'bi bi-pencil-square';      // изменить
    const DELETE        = 'bi bi-trash';              // удалить
    const PLUS          = 'bi bi-plus-lg';            // плюс



    const BANK           = 'bi bi-bank';
    const TYPE           = 'bi bi-list';



    const SPEND          = 'bi bi-cart-dash';
    const LOGOUT         = 'bi bi-box-arrow-right';
    const DEPOSITS       = 'bi bi-box-arrow-in-down';
    const CREDITS        = 'bi bi-calculator';
    const CHECK_UP       = 'bi bi-arrow-bar-up';
    const CHECK_DOWN     = 'bi bi-arrow-bar-down';
    const CHECK          = 'bi bi-check2-all';
    const PROFIT_UP      = 'bi bi-bar-chart';
    const BALANCE_UP     = 'bi bi-box-arrow-in-down';
    const BALANCE_DOWN   = 'bi bi-box-arrow-up';

    const AMOUNT         = 'bi bi-collection';
    const PERCENT        = 'bi bi-percent';
    const PERIOD         = 'bi bi-clock-history';
    const PAYMENT        = 'bi bi-cash-stack';


    const CALENDAR_MONTH = 'bi bi-calendar3';
    const CALENDAR_DAY   = 'bi bi-calendar2-date';
    const CHECK_LIST     = 'bi bi-card-checklist';
    const CHECKED        = 'bi bi-check2-all';

    const CAPITALIZATION = 'bi bi-cash-coin';
    const WITHDRAWAL     = 'bi bi-arrow-counterclockwise';
    const COUNTER        = 'bi bi-123';

    const QUESTION       = 'bi bi-question-circle';

    const PAYING         = 'bi bi-hourglass-top';
    const WAS_PAYED      = 'bi-hourglass-split';
    const WILL_PAY       = 'bi bi-hourglass-bottom';

    const SMILE_HAPPY    = 'bi bi-emoji-smile';
    const SMILE_NEUTRAL  = 'bi bi-emoji-neutral';
    const SMILE_SAD      = 'bi bi-emoji-frown';

    const PAYMENT_CHECK   = 'bi bi-check2-square';
    const PAYMENT_OVERDUE = 'bi bi-exclamation-triangle';
    const PAYMENT_WAITING = 'bi bi-stopwatch';

    /**
     * @param string $class
     * @return string
     */
    public static function get(string $class): string
    {
        return '<i class="' . $class . '"></i>';
    }

}
