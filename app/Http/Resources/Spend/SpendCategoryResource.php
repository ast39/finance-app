<?php

namespace App\Http\Resources\Spend;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpendCategoryResource extends JsonResource {

    public static $wrap = 'data';


    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'category_id' => $this->category_id ?? null,
            'title'       => $this->title       ?? null,
            'parent'      => new SpendCategoryResource($this->parent),
            'created'     => $this->created_at  ?? null,
        ];
    }
}
