<?php

namespace App\Http\Resources\Deposit;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepositResource extends JsonResource {

    public static $wrap = 'data';


    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'deposit_id'   => $this->deposit_id    ?? null,
            'owner'        => new UserResource($this->owner),
            'title'        => $this->title         ?? null,
            'depositor'    => $this->depositor     ?? null,
            'amount'       => $this->amount        ?? null,
            'percent'      => $this->percent       ?? null,
            'period'       => $this->period        ?? null,
            'refill'       => $this->refill        ?? null,
            'plow_back'    => $this->plow_back     ?? null,
            'withdrawal'   => $this->withdrawal    ?? null,
            'start_date'   => $this->start_date    ?? null,
            'status'       => $this->status        ?? null,
            'created'      => $this->created_at    ?? null,
            'payments'     => DepositPaymentResource::collection($this->payments),
        ];
    }
}
