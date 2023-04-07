<?php

namespace App\Http\Controllers\Credit;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Dictionarable;
use App\Http\Mutators\CreditCalculateMutator;
use App\Http\Requests\Credit\CreditCalcRequest;
use App\Libs\CreditSubject;
use App\Libs\Finance\Credit\CreditManager;
use App\Libs\Finance\Credit\ResponseData;
use App\Libs\Finance\Exceptions\RequestDataException;
use App\Models\Credit\Credit;
use App\Models\Credit\CreditCalculate;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CreditCalcController extends Controller {

    use Dictionarable;


    /**
     * @return View
     */
    public function create(): View
    {
        return view('credit.calc.create', [
            'currencies' => $this->walletCurrencies(),
        ]);
    }

    /**
     * @param CreditCalcRequest $request
     * @return RedirectResponse
     */
    public function store(CreditCalcRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $id = CreditCalculate::create($data)->credit_id;

        return redirect()->route('credit.calc.show', $id);
    }

    /**
     * @param int $id
     * @return View|RedirectResponse
     * @throws RequestDataException
     */
    public function show(int $id): View|RedirectResponse
    {
        $credit = CreditCalculate::findOrFail($id);

        $credit = (new CreditCalculateMutator())($credit);

        if (!($credit instanceof ResponseData)) {
            return redirect()->route('credit.calc.create')->withErrors(['action' => 'Ошибка ' . $credit]);
        }

        return view('credit.calc.show', [
            'info' => $credit
        ]);
    }

}
