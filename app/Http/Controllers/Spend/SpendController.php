<?php

namespace App\Http\Controllers\Spend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Dictionarable;
use App\Http\Filters\SpendFilter;
use App\Http\Requests\Spend\SpendFilterRequest;
use App\Http\Requests\Spend\SpendStoreRequest;
use App\Http\Requests\Spend\SpendUpdateRequest;
use App\Models\Spend\Spend;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class SpendController extends Controller {

    use Dictionarable;


    /**
     * @param SpendFilterRequest $request
     * @return View
     * @throws BindingResolutionException
     */
    public function index(SpendFilterRequest $request): View
    {
        $data = $request->validated();

        $filter = app()->make(SpendFilter::class, [
            'queryParams' => array_filter($data)
        ]);

        $page_spends = Spend::where('owner_id', Auth::id())
            ->filter($filter)
            ->where('status', config('statuses.on'))
            ->orderByDesc('created_at')
            ->paginate(config('limits.spend'));

        return view('spend.index', [
            'spends'     => $page_spends,
            'categories' => $this->spendCategories(),
            'wallets'    => $this->allWallets(),
        ]);
    }

    public function create(): View
    {
        return view('spend.create', [
            'wallets'    => $this->allWallets(),
            'categories' => $this->spendCategories(),
        ]);
    }

    public function store(SpendStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['owner_id'] = Auth::id();

        return redirect()->route('wallet.show', Spend::create($data)->spend_id);
    }

    public function show(int $id): View
    {

    }

    public function edit(int $id): View
    {

    }

    public function update(SpendUpdateRequest $request, int $id): RedirectResponse
    {

    }

    public function destroy(int $id): RedirectResponse
    {

    }
}
