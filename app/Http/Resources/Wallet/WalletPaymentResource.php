<?php

namespace App\Http\Resources\Wallet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletPaymentResource extends JsonResource {

    public static $wrap = 'data';


    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'payment_id' => $this->payment_id ?? null,
            'wallet'     => new WalletResource($this->wallet),
            'amount'     => $this->amount     ?? null,
            'note'       => $this->note       ?? null,
            'status'     => $this->status     ?? null,
        ];
    }
}
