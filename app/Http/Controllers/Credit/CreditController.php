<?php

namespace App\Http\Controllers\Credit;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Dictionarable;
use App\Http\Filters\CreditFilter;
use App\Http\Mutators\CreditMutator;
use App\Http\Mutators\CreditSaldoMurtator;
use App\Http\Requests\Credit\CreditStoreRequest;
use App\Http\Requests\Credit\CreditUpdateRequest;
use App\Http\Requests\Wallet\WalletFilterRequest;
use App\Libs\Finance\Exceptions\RequestDataException;
use App\Models\Credit\Credit;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CreditController extends Controller {

    use Dictionarable;


    /**
     * @param WalletFilterRequest $request
     * @param string|null $sortable
     * @return View
     * @throws BindingResolutionException
     * @throws RequestDataException
     */
    public function index(WalletFilterRequest $request, ?string $sortable = null): View
    {
        $sortable = in_array($sortable, ['till', 'percent', 'payment', 'amount', 'overpay'])
            ? $sortable
            : 'till';

        $data = $request->validated();

        $filter = app()->make(CreditFilter::class, [
            'queryParams' => array_filter($data)
        ]);

        $_credits = Credit::where('owner_id', Auth::id())
            ->filter($filter)
            ->where('status', config('statuses.on'))
            ->orderBy('currency')
            ->orderBy('title')
            ->get();

        $credits = [];
        foreach ($_credits as $id => $credit) {
            $credits[$id] = (new CreditMutator())($credit);
        }

        $saldo = (new CreditSaldoMurtator())($credits);

        return view('credit.index', [
            'credits'  => $credits,
            'saldo'    => $saldo,
            'sortable' => $sortable,
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('credit.create', [
            'currencies' => $this->walletCurrencies(),
        ]);
    }

    /**
     * @param CreditStoreRequest $request
     * @return RedirectResponse
     */
    public function store(CreditStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['owner_id']     = Auth::id();
        $data['start_date']   = strtotime(($data['start_date']   ?? date('d.m.Y', time())) . ' 09:00:00');
        $data['payment_date'] = strtotime(($data['payment_date'] ?? date('d.m.Y', time())) . ' 09:00:00');

        return redirect()->route('credit.show', Credit::create($data)->credit_id);
    }

    /**
     * @param int $id
     * @return View
     * @throws RequestDataException
     */
    public function show(int $id): View
    {
        $credit = Credit::where('owner_id', Auth::id())
            ->findOrFail($id);

        $credit = (new CreditMutator())($credit);

        return view('credit.show', [
            'credit'=> $credit,
        ]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        return view('credit.edit', [
            'credit'    => Credit::where('owner_id', Auth::id())
                ->findOrFail($id),
            'currencies' => $this->walletCurrencies(),
        ]);
    }

    /**
     * @param CreditUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(CreditUpdateRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();

        $data['start_date']   = strtotime(($data['start_date']   ?? date('d.m.Y', time())) . ' 09:00:00');
        $data['payment_date'] = strtotime(($data['payment_date'] ?? date('d.m.Y', time())) . ' 09:00:00');

        $credit = Credit::find($id);
        if (is_null($credit)) {
            return back()->withErrors(['action' => 'Обновляемый кредит не найден']);
        }

        $credit->update($data);

        return redirect()->route('credit.show', $id);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $credit = Credit::find($id);
        if (is_null($credit)) {
            return back()->withErrors(['action' => 'Удаляемый кредит не найден']);
        }

        $credit->delete();

        return redirect()->route('credit.index');
    }
}
