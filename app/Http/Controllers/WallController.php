<?php

namespace App\Http\Controllers;

use App\Http\Mutators\CreditEventMutator;
use App\Models\Credit\Credit;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class WallController extends Controller {

    public function __invoke(): View
    {
        $credits = Cache::remember('wall.' . Auth::id(), config('cache.time'), function() {

            return Credit::where('owner_id', Auth::id())
                ->where('status', config('statuses.on'))
                ->orderBy('payment_date')
                ->orderBy('creditor')
                ->get();
        });

        $credits = (new CreditEventMutator())($credits);

        $credits = Arr::sort($credits, function($e) {
            return (int) date('d', $e['date_time']);
        });

        return view('wall.index', [
            'credits' => $credits,
        ]);
    }
}
