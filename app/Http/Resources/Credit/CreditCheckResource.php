<?php

namespace App\Http\Resources\Credit;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CreditCheckResource extends JsonResource {

    public static $wrap = 'data';


    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'calc_id'  => $this->calc_id    ?? null,
            'title'    => $this->title      ?? null,
            'amount'   => $this->amount     ?? null,
            'percent'  => $this->percent    ?? null,
            'period'   => $this->period     ?? null,
            'payment'  => $this->payment    ?? null,
            'status'   => $this->status     ?? null,
            'created'  => $this->created_at ?? null,
        ];
    }
}
