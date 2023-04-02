<?php

namespace App\Http\Resources\Credit;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreditCalculateResource extends JsonResource {

    public static $wrap = 'data';


    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'credit_id'    => $this->credit_id    ?? null,
            'payment_type' => $this->payment_type ?? null,
            'subject'      => $this->subject      ?? null,
            'amount'       => $this->amount       ?? null,
            'percent'      => $this->percent      ?? null,
            'period'       => $this->period       ?? null,
            'payment'      => $this->payment      ?? null,
            'status'       => $this->status       ?? null,
            'created'      => $this->created_at   ?? null,
        ];
    }
}
