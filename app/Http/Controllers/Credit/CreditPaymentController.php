<?php

namespace App\Http\Controllers\Credit;

use App\Http\Controllers\Controller;
use App\Http\Requests\Credit\Payment\CreditPaymentStoreRequest;
use App\Http\Requests\Credit\Payment\CreditPaymentUpdateRequest;
use App\Models\Credit\Credit;
use App\Models\Credit\CreditPayment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CreditPaymentController extends Controller {

    /**
     * @param int $credit_id
     * @return View
     */
    public function create(int $credit_id): View
    {
        $credit = Credit::findOrFail($credit_id);

        return view('credit.payment.create', [
            'credit' => $credit,
        ]);
    }

    /**
     * @param CreditPaymentStoreRequest $request
     * @return RedirectResponse
     */
    public function store(CreditPaymentStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        CreditPayment::create($data);

        return redirect()->route('credit.show', $data['credit_id']);
    }

    /**
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $credit = Credit::findOrFail($id);

        return view('credit.show', [
            'credit'  => $credit,
        ]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        return view('credit.payment.edit', [
            'payment' => CreditPayment::findOrFail($id)
        ]);
    }

    /**
     * @param CreditPaymentUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(CreditPaymentUpdateRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();

        $payment = CreditPayment::find($id);
        if (is_null($payment)) {
            return back()->withErrors(['action' => 'Обновляемый платеж не найден']);
        }

        $payment->update($data);

        return redirect()->route('credit.show', $payment->credit_id);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $payment = CreditPayment::find($id);
        if (is_null($payment)) {
            return back()->withErrors(['action' => 'Удаляемый платеж не найден']);
        }

        $payment->delete();

        return redirect()->route('credit.show', $payment->credit_id);
    }
}
