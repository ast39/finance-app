<?php

namespace App\Http\Resources\Wallet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepositCurrencyResource extends JsonResource {

    public static $wrap = 'data';


    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'currency_id' => $this->currency_id ?? null,
            'title'       => $this->title       ?? null,
            'abbr'        => $this->abbr        ?? null,
            'status'      => $this->status      ?? null,
        ];
    }
}
