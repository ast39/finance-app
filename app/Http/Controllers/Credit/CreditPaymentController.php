<?php

namespace App\Http\Controllers\Credit;

use App\Http\Controllers\Controller;
use App\Http\Requests\Credit\Payment\CreditPaymentStoreRequest;
use App\Http\Requests\Credit\Payment\CreditPaymentUpdateRequest;
use App\Models\Credit\Credit;
use App\Models\Credit\CreditPayment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
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
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $payment = CreditPayment::find($id);
        if (is_null($payment)) {
            return response()->json(['error' => true]);
        }

        $payment->delete();

        return response()->json(['data' => true]);
    }
}
