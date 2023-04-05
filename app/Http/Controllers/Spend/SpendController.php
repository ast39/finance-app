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
            'spend_list' => $this->allSpends(true),
            'categories' => $this->spendCategories(),
            'wallets'    => $this->allWallets(),
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('spend.create', [
            'wallets'    => $this->allWallets(),
            'categories' => $this->spendCategories(),
        ]);
    }

    /**
     * @param SpendStoreRequest $request
     * @return RedirectResponse
     */
    public function store(SpendStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['owner_id'] = Auth::id();

        Spend::create($data);

        return redirect()->route('spend.index');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $spend = Spend::find($id);
        if (is_null($spend)) {
            abort(404);
        }

        return view('spend.edit', [
            'spend'      => $spend,
            'wallets'    => $this->allWallets(),
            'categories' => $this->spendCategories(),
        ]);
    }

    /**
     * @param SpendUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(SpendUpdateRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();

        $spend = Spend::find($id);
        if (is_null($spend)) {
            return back()->withErrors(['action' => 'Обновляемый расход не найден']);
        }

        $spend->update($data);

        return redirect()->route('spend.index');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $spend = Spend::find($id);
        if (is_null($spend)) {
            return back()->withErrors(['action' => 'Удаляемый расход не найден']);
        }

        $spend->delete();

        return redirect()->route('spend.index');
    }
}
