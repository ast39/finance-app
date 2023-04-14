<?php

namespace App\Http\Controllers\Deposit;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Credit\CreditCalcController;
use App\Http\Controllers\Traits\Dictionarable;
use App\Http\Mutators\DepositCalculateMutator;
use App\Http\Requests\Deposit\DepositCalcRequest;
use App\Libs\Finance\Deposit\ResponseData;
use App\Libs\Finance\Exceptions\RequestDataException;
use App\Models\Credit\CreditCalculate;
use App\Models\Deposit\DepositCalculate;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DepositCalcController extends Controller {

    use Dictionarable;


    /**
     * @return View
     */
    public function index(): view
    {
        $page_deposits = DepositCalculate::where('owner_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(config('limits.history'));

        return view('deposit.calc.index', [
            'deposits' => $page_deposits,
        ]);
    }

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
        $data['start_date'] = strtotime(($data['start_date'] ?? date('d.m.Y', time())) . ' 09:00:00');
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
        # Расчет проводит авторизованный пользователь
        if (Auth::check()) {

            # Расчет должен принадлежать ему
            $deposit = DepositCalculate::where('owner_id', Auth::id())
                ->findOrFail($id);
        }
        # Расчет проводит гость
        else {

            # Расчет должен быть гостевой
            $deposit = DepositCalculate::where('owner_id', null)
                ->findOrFail($id);
        }

        $deposit_data = (new DepositCalculateMutator())($deposit);

        # Удаляем расчет, если он гостевой, чтобы не захламлять БД
        # (то есть гостевой расчет доступен 1 раз до перезагрузки страницы)
        if (is_null($deposit->owner_id) && !Auth::check()) {
            $deposit->delete();
        }

        if (!($deposit_data instanceof ResponseData)) {
            return redirect()->route('deposit.calc.create')->withErrors(['action' => 'Ошибка ' . $deposit_data]);
        }

        return view('deposit.calc.show', [
            'info' => $deposit_data
        ]);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $calculate = DepositCalculate::find($id);
        if (is_null($calculate)) {
            return back()->withErrors(['action' => 'Удаляемый расчет не найден']);
        }

        $calculate->delete();

        return redirect()->route('deposit.calc.index');
    }

}
