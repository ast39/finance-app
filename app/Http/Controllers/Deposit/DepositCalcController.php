<?php

namespace App\Http\Controllers\Deposit;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Dictionarable;
use App\Http\Mutators\DepositCalculateMutator;
use App\Http\Requests\Deposit\DepositCalcRequest;
use App\Libs\Finance\Deposit\ResponseData;
use App\Libs\Finance\Exceptions\RequestDataException;
use App\Models\Deposit\DepositCalculate;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DepositCalcController extends Controller {

    use Dictionarable;


    /**
     * @return View
     */
    public function create(): View
    {
        return view('deposit.calc.create', [
            'currencies' => $this->walletCurrencies(),
        ]);
    }

    /**
     * @param DepositCalcRequest $request
     * @return RedirectResponse
     */
    public function store(DepositCalcRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['owner_id'] = Auth::id() ?? null;
        $data['withdrawal'] = ($data['withdrawal'] ?? 'off') == 'on' ? 1 : 0;
        $data['start_date'] = strtotime(($data['start_date'] ?? date('d-m-Y', time())) . ' 09:00:00');
        $id = DepositCalculate::create($data)->deposit_id;

        return redirect()->route('deposit.calc.show', $id);
    }

    /**
     * @param int $id
     * @return View|RedirectResponse
     * @throws RequestDataException
     */
    public function show(int $id): View|RedirectResponse
    {
        $deposit = DepositCalculate::findOrFail($id);

        $deposit = (new DepositCalculateMutator())($deposit);

        if (!($deposit instanceof ResponseData)) {
            return redirect()->route('deposit.calc.create')->withErrors(['action' => 'Ошибка ' . $deposit]);
        }

        return view('deposit.calc.show', [
            'info' => $deposit
        ]);
    }

}
