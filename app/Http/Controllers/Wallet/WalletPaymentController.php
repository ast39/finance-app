<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet\Payment\WalletPaymentStoreRequest;
use App\Http\Requests\Wallet\Payment\WalletPaymentUpdateRequest;
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

    /**
     * @param WalletPaymentStoreRequest $request
     * @return RedirectResponse
     */
    public function store(WalletPaymentStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        WalletPayment::create($data);

        return redirect()->route('wallet.index');
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

    /**
     * @param WalletPaymentUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(WalletPaymentUpdateRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();

        $payment = WalletPayment::find($id);
        if (is_null($payment)) {
            return back()->withErrors(['action' => 'Обновляемая транзакция не найдена']);
        }

        $payment->update($data);

        return redirect()->route('wallet.show', $payment->wallet_id);
    }

    public function destroy(int $id): RedirectResponse
    {
        $payment = WalletPayment::find($id);
        if (is_null($payment)) {
            return redirect()->back()->withErrors(['action' => 'Удаляемая транзакция не найдена']);
        }

        $payment->delete();

        return redirect()->back();
    }
}
