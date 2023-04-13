<?php

namespace App\Http\Controllers\Spend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\Dictionarable;
use App\Http\Requests\Spend\Category\SpendCategoryStoreRequest;
use App\Http\Requests\Spend\Category\SpendCategoryUpdateRequest;
use App\Http\Requests\Wallet\WalletFilterRequest;
use App\Models\Spend\SpendCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SpendCategoryController extends Controller {

    use Dictionarable;


    public function index(WalletFilterRequest $request): View
    {
        $page_categories = SpendCategory::orderBy('title')
            ->paginate(config('limits.categories'));

        return view('spend.category.index', [
            'categories'  => $page_categories,
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('spend.category.create');
    }

    /**
     * @param SpendCategoryStoreRequest $request
     * @return RedirectResponse
     */
    public function store(SpendCategoryStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        SpendCategory::create($data);

        return redirect()->route('spend.category.index');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $category = SpendCategory::find($id);
        if (is_null($category)) {
            abort(404);
        }

        return view('spend.category.edit', [
            'category' => $category,
        ]);
    }

    /**
     * @param SpendCategoryUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(SpendCategoryUpdateRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();

        $category = SpendCategory::find($id);
        if (is_null($category)) {
            return back()->withErrors(['action' => 'Обновляемая категория не найдена']);
        }

        $category->update($data);

        return redirect()->route('spend.category.index');
    }

    public function destroy(int $id): RedirectResponse
    {
        $category = SpendCategory::find($id);
        if (is_null($category)) {
            return back()->withErrors(['action' => 'Удаляемая категория не найдена']);
        }

        $category->delete();

        return redirect()->route('spend.category.index');
    }
}
