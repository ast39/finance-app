<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Filters\WalletFilter;
use App\Http\Requests\Wallet\WalletFilterRequest;
use App\Models\Wallet\Wallet;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller {

    public function index(WalletFilterRequest $request): View
    {
        $data = $request->validated();

        $filter = app()->make(WalletFilter::class, [
            'queryParams' => array_filter($data)
        ]);

        $safes_all = Wallet::where('owner_id', Auth::id())
            ->get()
            ->toArray();

        $safes_page = Wallet::where('owner_id', Auth::id())
            ->filter($filter)
            ->paginate(config('user.limits.wallet'));

        return view('wallet.index', [
            'wallets' => $safes_page,
            'balance' => $safes_all,
        ]);
    }

    public function create(): View
    {
        return view('wallet.create');
    }

    public function store(): RedirectResponse
    {

    }

    public function show(int $id): View
    {

    }

    public function edit(int $id): View
    {
        return view('wallet.edit');
    }

    public function update(int $id): RedirectResponse
    {

    }

    public function destroy(int $id): RedirectResponse
    {

    }
}
