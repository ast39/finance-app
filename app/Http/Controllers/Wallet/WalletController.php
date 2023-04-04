<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Dictionarable;
use App\Http\Filters\WalletFilter;
use App\Http\Mutators\WalletMutator;
use App\Http\Requests\Wallet\WalletFilterRequest;
use App\Http\Requests\Wallet\WalletStoreRequest;
use App\Http\Requests\Wallet\WalletUpdateRequest;
use App\Models\Wallet\Wallet;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller {

    use Dictionarable;


    /**
     * @param WalletFilterRequest $request
     * @return View
     * @throws BindingResolutionException
     */
    public function index(WalletFilterRequest $request): View
    {
        $data = $request->validated();

        $filter = app()->make(WalletFilter::class, [
            'queryParams' => array_filter($data)
        ]);

        $page_wallets = Wallet::where('owner_id', Auth::id())
            ->filter($filter)
            ->where('status', config('statuses.on'))
            ->orderBy('currency_id')
            ->orderBy('title')
            ->paginate(config('limits.wallet'));

        return view('wallet.index', [
            'wallets'     => $page_wallets,
            'wallet_list' => $this->allWallets(),
            'currencies'  => $this->walletCurrencies(),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('wallet.create', [
            'currencies' => $this->walletCurrencies(),
        ]);
    }

    /**
     * @param WalletStoreRequest $request
     * @return RedirectResponse
     */
    public function store(WalletStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['owner_id'] = Auth::id();

        return redirect()->route('wallet.show', Wallet::create($data)->wallet_id);
    }

    /**
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $wallet = Wallet::find($id);
        if (is_null($wallet)) {
            abort(404);
        }

        return view('wallet.show', [
            'wallet'  => (new WalletMutator())($wallet),
        ]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $wallet = Wallet::find($id);
        if (is_null($wallet)) {
            abort(404);
        }

        return view('wallet.edit', [
            'wallet' => $wallet,
        ]);
    }

    /**
     * @param WalletUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(WalletUpdateRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();

        $wallet = Wallet::find($id);
        if (is_null($wallet)) {
            return back()->withErrors(['action' => 'Обновляемый кошелек не найден']);
        }

        $wallet->update($data);

        return redirect()->route('wallet.show', $id);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $wallet = Wallet::find($id);
        if (is_null($wallet)) {
            return back()->withErrors(['action' => 'Удаляемый кошелек не найден']);
        }

        $wallet->delete();

        return redirect()->route('wallet.index');
    }
}
