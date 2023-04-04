<?php

namespace App\Http\Resources\Spend;

use App\Http\Resources\UserResource;
use App\Http\Resources\Wallet\WalletResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpendResource extends JsonResource {

    public static $wrap = 'data';


    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'spend_id'    => $this->spend_id     ?? null,
            'owner'       => new UserResource($this->owner),
            'wallet'      => new WalletResource($this->wallet),
            'category'    => new SpendCategoryResource($this->category),
            'amount'      => $this->amount       ?? null,
            'note'        => $this->note         ?? null,
            'status'      => $this->status       ?? null,
            'created'     => $this->created_at   ?? null,
        ];
    }
}
