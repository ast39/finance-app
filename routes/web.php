<?php

use App\Http\Controllers\Wallet\{
    WalletController, WalletPaymentController, WalletCurrencyController
};

use App\Http\Controllers\Credit\{
    CreditController, CreditCalcController, CreditCheckController, CreditPaymentController
};

use App\Http\Controllers\Deposit\{
    DepositController, DepositCalcController, DepositPaymentController
};

use App\Http\Controllers\Spend\{
    SpendController, SpendCategoryController
};

use Illuminate\Support\Facades\{
    Route, Auth
};


Route::get('/', function () {
    return redirect('/wallet/item');
});

# Кошелек
Route::group(['prefix' => 'wallet', 'middleware' => ['auth']], function() {

    # Сами кошельки
    Route::group(['prefix' => 'item'], function() {

        Route::get('', [WalletController::class, 'index'])->name('wallet.index');
        Route::get('create', [WalletController::class, 'create'])->name('wallet.create');
        Route::post('', [WalletController::class, 'store'])->name('wallet.store');
        Route::get('{id}', [WalletController::class, 'show'])->name('wallet.show');
        Route::get('{id}/edit', [WalletController::class, 'edit'])->name('wallet.edit');
        Route::put('{id}', [WalletController::class, 'update'])->name('wallet.update');
        Route::delete('{id}', [WalletController::class, 'destroy'])->name('wallet.destroy');
    });

    # Переводы по кошелькам
    Route::group(['prefix' => 'payment'], function() {

        Route::get('create/{wallet_id}', [WalletPaymentController::class, 'create'])->name('wallet.payment.create');
        Route::post('', [WalletPaymentController::class, 'store'])->name('wallet.payment.store');
        Route::get('{id}/edit', [WalletPaymentController::class, 'edit'])->name('wallet.payment.edit');
        Route::put('{id}', [WalletPaymentController::class, 'update'])->name('wallet.payment.update');
        Route::delete('{id}', [WalletPaymentController::class, 'destroy'])->name('wallet.payment.destroy');
    });

    # Валюты кошельков
    Route::group(['prefix' => 'currency'], function() {

        Route::get('', [WalletCurrencyController::class, 'index'])->name('wallet.currency.index');
        Route::get('create', [WalletCurrencyController::class, 'create'])->name('wallet.currency.create');
        Route::post('', [WalletCurrencyController::class, 'store'])->name('wallet.currency.store');
        Route::get('{id}', [WalletCurrencyController::class, 'show'])->name('wallet.currency.show');
        Route::get('{id}/edit', [WalletCurrencyController::class, 'edit'])->name('wallet.currency.edit');
        Route::put('{id}', [WalletCurrencyController::class, 'update'])->name('wallet.currency.update');
        Route::delete('{id}', [WalletCurrencyController::class, 'destroy'])->name('wallet.currency.destroy');
    });
});

# Кредит
Route::group(['prefix' => 'credit', 'middleware' => ['auth']], function() {

    # Кредиты
    Route::group(['prefix' => 'list'], function () {

        Route::get('', [CreditController::class, 'index'])->name('credit.list.index');
        Route::get('create', [CreditController::class, 'create'])->name('credit.list.create');
        Route::post('', [CreditController::class, 'store'])->name('credit.list.store');
        Route::get('{id}', [CreditController::class, 'show'])->name('credit.list.show');
        Route::get('{id}/edit', [CreditController::class, 'edit'])->name('credit.list.edit');
        Route::put('{id}', [CreditController::class, 'update'])->name('credit.list.update');
        Route::delete('{id}', [CreditController::class, 'destroy'])->name('credit.list.destroy');
    });

    # Калькуляция
    Route::group(['prefix' => 'calculate'], function () {

        Route::get('create', [CreditCalcController::class, 'create'])->name('credit.calc.create');
        Route::post('', [CreditCalcController::class, 'store'])->name('credit.calc.store');
        Route::get('{id}', [CreditCalcController::class, 'show'])->name('credit.calc.show');
    });

    # Проверка
    Route::group(['prefix' => 'check'], function () {

        Route::get('create', [CreditCheckController::class, 'create'])->name('credit.check.create');
        Route::post('', [CreditCheckController::class, 'store'])->name('credit.check.store');
        Route::get('{id}', [CreditCheckController::class, 'show'])->name('credit.check.show');
    });

    # Транзакции
    Route::group(['prefix' => 'payment'], function () {

        Route::get('', [CreditPaymentController::class, 'index'])->name('credit.payment.index');
        Route::get('create', [CreditPaymentController::class, 'create'])->name('credit.payment.create');
        Route::post('', [CreditPaymentController::class, 'store'])->name('credit.payment.store');
        Route::get('{id}', [CreditPaymentController::class, 'show'])->name('credit.payment.show');
        Route::get('{id}/edit', [CreditPaymentController::class, 'edit'])->name('credit.payment.edit');
        Route::put('{id}', [CreditPaymentController::class, 'update'])->name('credit.payment.update');
        Route::delete('{id}', [CreditPaymentController::class, 'destroy'])->name('credit.payment.destroy');
    });
});

# Вклад
Route::group(['prefix' => 'deposit', 'middleware' => ['auth']], function() {

    # Вклады
    Route::group(['prefix' => 'list'], function () {

        Route::get('', [DepositController::class, 'index'])->name('deposit.list.index');
        Route::get('create', [DepositController::class, 'create'])->name('deposit.list.create');
        Route::post('', [DepositController::class, 'store'])->name('deposit.list.store');
        Route::get('{id}', [DepositController::class, 'show'])->name('deposit.list.show');
        Route::get('{id}/edit', [DepositController::class, 'edit'])->name('deposit.list.edit');
        Route::put('{id}', [DepositController::class, 'update'])->name('deposit.list.update');
        Route::delete('{id}', [DepositController::class, 'destroy'])->name('deposit.list.destroy');
    });

    # Калькуляция
    Route::group(['prefix' => 'calculate'], function () {

        Route::get('create', [DepositCalcController::class, 'create'])->name('deposit.calc.create');
        Route::post('', [DepositCalcController::class, 'store'])->name('deposit.calc.store');
        Route::get('{id}', [DepositCalcController::class, 'show'])->name('deposit.calc.show');
    });

    # Транзакции
    Route::group(['prefix' => 'payment'], function () {

        Route::get('', [DepositPaymentController::class, 'index'])->name('deposit.payment.index');
        Route::get('create', [DepositPaymentController::class, 'create'])->name('deposit.payment.create');
        Route::post('', [DepositPaymentController::class, 'store'])->name('deposit.payment.store');
        Route::get('{id}', [DepositPaymentController::class, 'show'])->name('deposit.payment.show');
        Route::get('{id}/edit', [DepositPaymentController::class, 'edit'])->name('deposit.payment.edit');
        Route::put('{id}', [DepositPaymentController::class, 'update'])->name('deposit.payment.update');
        Route::delete('{id}', [DepositPaymentController::class, 'destroy'])->name('deposit.payment.destroy');
    });
});

# Траты
Route::group(['prefix' => 'spend', 'middleware' => ['auth']], function() {

    # Расходы
    Route::group(['prefix' => 'item'], function () {

        Route::get('', [SpendController::class, 'index'])->name('spend.index');
        Route::get('create', [SpendController::class, 'create'])->name('spend.create');
        Route::post('', [SpendController::class, 'store'])->name('spend.store');
        Route::get('{id}', [SpendController::class, 'show'])->name('spend.show');
        Route::get('{id}/edit', [SpendController::class, 'edit'])->name('spend.edit');
        Route::put('{id}', [SpendController::class, 'update'])->name('spend.update');
        Route::delete('{id}', [SpendController::class, 'destroy'])->name('spend.destroy');
    });

    # Категории
    Route::group(['prefix' => 'category'], function () {

        Route::get('', [SpendCategoryController::class, 'index'])->name('spend.category.index');
        Route::get('create', [SpendCategoryController::class, 'create'])->name('spend.category.create');
        Route::post('', [SpendCategoryController::class, 'store'])->name('spend.category.store');
        Route::get('{id}', [SpendCategoryController::class, 'show'])->name('spend.category.show');
        Route::get('{id}/edit', [SpendCategoryController::class, 'edit'])->name('spend.category.edit');
        Route::put('{id}', [SpendCategoryController::class, 'update'])->name('spend.category.update');
        Route::delete('{id}', [SpendCategoryController::class, 'destroy'])->name('spend.category.destroy');
    });
});

Auth::routes();
