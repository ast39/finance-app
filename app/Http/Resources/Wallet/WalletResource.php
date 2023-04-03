<?php

namespace App\Http\Resources\Wallet;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource {

    public static $wrap = 'data';


    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'wallet_id' => $this->wallet_id ?? null,
            'currency'  => new WalletCurrencyResource($this->currency),
            'owner'     => new UserResource($this->owner),
            'title'     => $this->title     ?? null,
            'note'      => $this->note      ?? null,
            'amount'    => $this->amount    ?? null,
            'status'    => $this->status    ?? null,
        ];
    }
}
