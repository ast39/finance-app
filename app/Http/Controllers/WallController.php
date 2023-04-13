<?php

namespace App\Http\Controllers;

use App\Http\Mutators\CreditEventMutator;
use App\Models\Credit\Credit;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class WallController extends Controller {

    public function __invoke(): View
    {
        $credits = Credit::where('owner_id', Auth::id())
            ->where('status', config('statuses.on'))
            ->orderBy('payment_date')
            ->orderBy('creditor')
            ->get();

        $credits = (new CreditEventMutator())($credits);

        return view('wall.index', [
            'credits' => $credits,
        ]);
    }
}
