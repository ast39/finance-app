<?php

namespace App\Http\Requests\Spend;

use Illuminate\Foundation\Http\FormRequest;

class SpendUpdateRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [

            'wallet_id'   => 'integer',
            'category_id' => 'integer',
            'note'        => 'string|nullable',
            'amount'      => [
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
        ];
    }
}
