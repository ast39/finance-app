<?php

namespace App\Http\Requests\Credit;

use Illuminate\Foundation\Http\FormRequest;

class CreditUpdateRequest extends FormRequest {

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

            'title'        => 'string',
            'currency'     => 'string',
            'creditor'     => 'string',
            'start_date'   => 'string',
            'payment_date' => 'string',
            'amount'       => [
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
            'percent'      => [
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
            'period'       => 'integer',
            'payment'      => [
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
        ];
    }
}
