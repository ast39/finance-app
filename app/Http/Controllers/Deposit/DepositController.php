<?php

namespace App\Http\Controllers\Deposit;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Dictionarable;
use App\Http\Filters\DepositFilter;
use App\Http\Mutators\DepositMutator;
use App\Http\Requests\Deposit\DepositFilterRequest;
use App\Http\Requests\Deposit\DepositStoreRequest;
use App\Http\Requests\Deposit\DepositUpdateRequest;
use App\Models\Deposit\Deposit;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller {

    use Dictionarable;


    /**
     * @param DepositFilterRequest $request
     * @return View
     * @throws BindingResolutionException
     */
    public function index(DepositFilterRequest $request): View
    {
        $data = $request->validated();

        $filter = app()->make(DepositFilter::class, [
            'queryParams' => array_filter($data)
        ]);

        $page_deposits = Deposit::where('owner_id', Auth::id())
            ->filter($filter)
            ->where('status', config('statuses.on'))
            ->orderBy('currency')
            ->orderBy('title')
            ->paginate(config('limits.deposits'));

        return view('deposit.index', [
            'deposits' => $page_deposits,
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('deposit.create', [
            'currencies' => $this->walletCurrencies(),
        ]);
    }

    /**
     * @param DepositStoreRequest $request
     * @return RedirectResponse
     */
    public function store(DepositStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['owner_id']   = Auth::id();
        $data['start_date'] = strtotime(($data['start_date'] ?? date('d.m.Y', time())) . ' 09:00:00');
        $data['withdrawal'] = ($data['withdrawal'] ?? 'off') == 'on' ? 1 : 0;

        return redirect()->route('deposit.show', Deposit::create($data)->deposit_id);
    }

    /**
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $deposit = Deposit::where('owner_id', Auth::id())
            ->findOrFail($id);

        $deposit = (new DepositMutator())($deposit);

        return view('deposit.show', [
            'deposit'  => $deposit,
        ]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        return view('deposit.edit', [
            'deposit'    => Deposit::where('owner_id', Auth::id())
                ->findOrFail($id),
            'currencies' => $this->walletCurrencies(),
        ]);
    }

    /**
     * @param DepositUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(DepositUpdateRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();

        $data['start_date'] = strtotime(($data['start_date'] ?? date('d.m.Y', time())) . ' 09:00:00');
        $data['withdrawal'] = ($data['withdrawal'] ?? 'off') == 'on' ? 1 : 0;

        $deposit = Deposit::find($id);
        if (is_null($deposit)) {
            return back()->withErrors(['action' => 'Обновляемый вклад не найден']);
        }

        $deposit->update($data);

        return redirect()->route('deposit.show', $id);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $deposit = Deposit::find($id);
        if (is_null($deposit)) {
            return back()->withErrors(['action' => 'Удаляемый вклад не найден']);
        }

        $deposit->delete();

        return redirect()->route('deposit.index');
    }
}
