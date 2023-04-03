<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Models\Wallet\Wallet;
use App\Models\Wallet\WalletPayment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class WalletPaymentController extends Controller {

    /**
     * @param int $wallet_id
     * @return View
     */
    public function create(int $wallet_id): View
    {
        $wallet = Wallet::findOrFail($wallet_id);
        if (is_null($wallet)) {
            abort(404);
        }

        return view('wallet.payment.create', [
            'wallet' => $wallet,
        ]);
    }

    public function store(): RedirectResponse
    {
        return redirect()->route('wallet.item.index');
    }

    public function edit(int $id): View
    {
        $payment = WalletPayment::findOrFail($id);
        if (is_null($payment)) {
            abort(404);
        }

        return view('wallet.payment.edit', [
            'payment' => $payment,
        ]);
    }

    public function update(int $id): RedirectResponse
    {
        return redirect()->route('wallet.item.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        $payment = WalletPayment::findOrFail($id);
        if (is_null($payment)) {
            redirect()->back()->withErrors(['action' => 'Удаляемая транзакция не найдена']);
        }

        $payment->delete();

        return redirect()->back();
    }
}
