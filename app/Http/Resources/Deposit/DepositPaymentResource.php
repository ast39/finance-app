<?php

namespace App\Http\Resources\Deposit;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepositPaymentResource extends JsonResource {

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
            'deposit'    => new DepositResource($this->deposit),
            'amount'     => $this->amount     ?? null,
            'note'       => $this->note       ?? null,
            'status'     => $this->status     ?? null,
            'created'    => $this->created_at ?? null,
        ];
    }
}
