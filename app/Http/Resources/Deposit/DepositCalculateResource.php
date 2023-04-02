<?php

namespace App\Http\Resources\Deposit;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepositCalculateResource extends JsonResource {

    public static $wrap = 'data';


    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'deposit_id'     => $this->deposit_id ?? null,
            'owner'          => new UserResource($this->owner),
            'title'          => $this->title      ?? null,
            'depositor'      => $this->depositor  ?? null,
            'amount'         => $this->amount     ?? null,
            'percent'        => $this->percent    ?? null,
            'period'         => $this->period     ?? null,
            'refill'         => $this->refill     ?? null,
            'capitalization' => $this->capitalization ?? null,
            'withdrawal'     => $this->refill     ?? null,
            'start_date'     => $this->refill     ?? null,
            'status'         => $this->status     ?? null,
            'created'        => $this->created_at ?? null,
        ];
    }
}
