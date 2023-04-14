<?php

namespace App\Http\Controllers\Credit;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Dictionarable;
use App\Http\Mutators\CreditCalculateMutator;
use App\Http\Requests\Credit\CreditCalcRequest;
use App\Libs\Finance\Credit\ResponseData;
use App\Libs\Finance\Exceptions\RequestDataException;
use App\Models\Credit\CreditCalculate;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CreditCalcController extends Controller {

    use Dictionarable;


    /**
     * @return View
     */
    public function index(): view
    {
        $page_credits = CreditCalculate::where('owner_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(config('limits.history'));

        return view('credit.calc.index', [
            'credits' => $page_credits,
        ]);
    }

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

        $data['owner_id'] = Auth::id() ?? null;
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
        # Расчет проводит авторизованный пользователь
        if (Auth::check()) {

            # Расчет должен принадлежать ему
            $credit = CreditCalculate::where('owner_id', Auth::id())
                ->findOrFail($id);
        }
        # Расчет проводит гость
        else {

            # Расчет должен быть гостевой
            $credit = CreditCalculate::where('owner_id', null)
                ->findOrFail($id);
        }

        $credit_data = (new CreditCalculateMutator())($credit);

        # Удаляем расчет, если он гостевой, чтобы не захламлять БД
        # (то есть гостевой расчет доступен 1 раз до перезагрузки страницы)
        if (is_null($credit->owner_id) && !Auth::check()) {
            $credit->delete();
        }

        if (!($credit_data instanceof ResponseData)) {
            return redirect()->route('credit.calc.create')->withErrors(['action' => 'Ошибка ' . $credit_data]);
        }

        return view('credit.calc.show', [
            'info' => $credit_data
        ]);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $calculate = CreditCalculate::find($id);
        if (is_null($calculate)) {
            return back()->withErrors(['action' => 'Удаляемый расчет не найден']);
        }

        $calculate->delete();

        return redirect()->route('credit.calc.index');
    }

}
