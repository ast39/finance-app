<?php

namespace App\Http\Controllers\Credit;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Dictionarable;
use App\Http\Mutators\CreditCheckMutator;
use App\Http\Requests\Credit\CreditCheckRequest;
use App\Libs\Finance\Fraud\ResponseData;
use App\Libs\Finance\Exceptions\RequestDataException;
use App\Models\Credit\CreditCheck;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CreditCheckController extends Controller {


    use Dictionarable;


    /**
     * @return View
     */
    public function create(): View
    {
        return view('credit.check.create', [
            'currencies' => $this->walletCurrencies(),
        ]);
    }

    /**
     * @param CreditCheckRequest $request
     * @return RedirectResponse
     */
    public function store(CreditCheckRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['owner_id'] = Auth::id() ?? null;
        $id = CreditCheck::create($data)->calc_id;

        return redirect()->route('credit.check.show', $id);
    }

    /**
     * @param int $id
     * @return View|RedirectResponse
     * @throws RequestDataException
     */
    public function show(int $id): View|RedirectResponse
    {
        $credit = CreditCheck::findOrFail($id);

        $credit = (new CreditCheckMutator())($credit);

        if (!($credit instanceof ResponseData)) {
            return redirect()->route('credit.check.create')->withErrors(['action' => 'Ошибка ' . $credit]);
        }

        return view('credit.check.show', [
            'checker' => $credit
        ]);
    }

}
