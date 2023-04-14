<?php

use App\Http\Controllers\Wallet\{
    WalletController, WalletPaymentController, WalletCurrencyController
};

use App\Http\Controllers\Credit\{
    CreditController, CreditCalcController, CreditCheckController, CreditPaymentController
};

use App\Http\Controllers\Deposit\{
    DepositController, DepositCalcController
};

use App\Http\Controllers\Spend\{
    SpendController, SpendCategoryController
};

use Illuminate\Support\Facades\{
    Route, Auth
};

use App\Http\Controllers\WallController;


Route::get('/', function () {
    return redirect('/wall');
});

# События
Route::get('wall', WallController::class)->middleware('auth')->name('wall.index');

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
Route::group(['prefix' => 'credit'], function() {

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

});

# Кредит
Route::group(['prefix' => 'credit', 'middleware' => ['auth']], function() {

    # Кредиты
    Route::group(['prefix' => 'item'], function () {

        Route::get('index/{sortable?}', [CreditController::class, 'index'])->name('credit.index');
        Route::get('create', [CreditController::class, 'create'])->name('credit.create');
        Route::post('', [CreditController::class, 'store'])->name('credit.store');
        Route::get('{id}', [CreditController::class, 'show'])->name('credit.show');
        Route::get('{id}/edit', [CreditController::class, 'edit'])->name('credit.edit');
        Route::put('{id}', [CreditController::class, 'update'])->name('credit.update');
        Route::delete('{id}', [CreditController::class, 'destroy'])->name('credit.destroy');
    });

    # Калькуляция
    Route::group(['prefix' => 'calculate'], function () {

        Route::get('', [CreditCalcController::class, 'index'])->name('credit.calc.index');
        Route::delete('{id}', [CreditCalcController::class, 'destroy'])->name('credit.calc.destroy');
    });

    # Проверка
    Route::group(['prefix' => 'check'], function () {

        Route::get('', [CreditCheckController::class, 'index'])->name('credit.check.index');
        Route::delete('{id}', [CreditCheckController::class, 'destroy'])->name('credit.check.destroy');
    });

    # Транзакции
    Route::group(['prefix' => 'payment'], function () {

        Route::get('create/{credit_id}', [CreditPaymentController::class, 'create'])->name('credit.payment.create');
        Route::post('', [CreditPaymentController::class, 'store'])->name('credit.payment.store');
        Route::delete('{id}', [CreditPaymentController::class, 'destroy'])->name('credit.payment.destroy');
    });
});

# Вклад
Route::group(['prefix' => 'deposit'], function() {

    # Калькуляция
    Route::group(['prefix' => 'calculate'], function () {

        Route::get('create', [DepositCalcController::class, 'create'])->name('deposit.calc.create');
        Route::post('', [DepositCalcController::class, 'store'])->name('deposit.calc.store');
        Route::get('{id}', [DepositCalcController::class, 'show'])->name('deposit.calc.show');
    });
});

# Вклад
Route::group(['prefix' => 'deposit', 'middleware' => ['auth']], function() {

    # Вклады
    Route::group(['prefix' => 'item'], function () {

        Route::get('', [DepositController::class, 'index'])->name('deposit.index');
        Route::get('create', [DepositController::class, 'create'])->name('deposit.create');
        Route::post('', [DepositController::class, 'store'])->name('deposit.store');
        Route::get('{id}', [DepositController::class, 'show'])->name('deposit.show');
        Route::get('{id}/edit', [DepositController::class, 'edit'])->name('deposit.edit');
        Route::put('{id}', [DepositController::class, 'update'])->name('deposit.update');
        Route::delete('{id}', [DepositController::class, 'destroy'])->name('deposit.destroy');
    });

    # Калькуляция
    Route::group(['prefix' => 'calculate'], function () {

        Route::get('', [DepositCalcController::class, 'index'])->name('deposit.calc.index');
        Route::delete('{id}', [DepositCalcController::class, 'destroy'])->name('deposit.calc.destroy');
    });
});

# Траты
Route::group(['prefix' => 'spend', 'middleware' => ['auth']], function() {

    # Расходы
    Route::group(['prefix' => 'item'], function () {

        Route::get('', [SpendController::class, 'index'])->name('spend.index');
        Route::get('create', [SpendController::class, 'create'])->name('spend.create');
        Route::post('', [SpendController::class, 'store'])->name('spend.store');
        Route::get('{id}/edit', [SpendController::class, 'edit'])->name('spend.edit');
        Route::put('{id}', [SpendController::class, 'update'])->name('spend.update');
        Route::delete('{id}', [SpendController::class, 'destroy'])->name('spend.destroy');
    });

    # Категории
    Route::group(['prefix' => 'category'], function () {

        Route::get('', [SpendCategoryController::class, 'index'])->name('spend.category.index');
        Route::get('create', [SpendCategoryController::class, 'create'])->name('spend.category.create');
        Route::post('', [SpendCategoryController::class, 'store'])->name('spend.category.store');
        Route::get('{id}/edit', [SpendCategoryController::class, 'edit'])->name('spend.category.edit');
        Route::put('{id}', [SpendCategoryController::class, 'update'])->name('spend.category.update');
        Route::delete('{id}', [SpendCategoryController::class, 'destroy'])->name('spend.category.destroy');
    });
});

Auth::routes();
