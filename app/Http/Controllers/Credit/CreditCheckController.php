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
    public function index(): view
    {
        $page_credits = CreditCheck::where('owner_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(config('limits.history'));

        return view('credit.check.index', [
            'credits' => $page_credits,
        ]);
    }

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
        # Расчет проводит авторизованный пользователь
        if (Auth::check()) {

            # Расчет должен принадлежать ему
            $credit = CreditCheck::where('owner_id', Auth::id())
                ->findOrFail($id);
        }
        # Расчет проводит гость
        else {

            # Расчет должен быть гостевой
            $credit = CreditCheck::where('owner_id', null)
                ->findOrFail($id);
        }

        $credit_data = (new CreditCheckMutator())($credit);

        # Удаляем расчет, если он гостевой, чтобы не захламлять БД
        # (то есть гостевой расчет доступен 1 раз до перезагрузки страницы)
        if (is_null($credit->owner_id) && !Auth::check()) {
            $credit->delete();
        }

        if (!($credit_data instanceof ResponseData)) {
            return redirect()->route('credit.check.create')->withErrors(['action' => 'Ошибка ' . $credit_data]);
        }

        return view('credit.check.show', [
            'checker' => $credit_data
        ]);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $check = CreditCheck::find($id);
        if (is_null($check)) {
            return back()->withErrors(['action' => 'Удаляемый расчет не найден']);
        }

        $check->delete();

        return redirect()->route('credit.check.index');
    }

}
