<?php

namespace App\Http\Requests\Credit;

use Illuminate\Foundation\Http\FormRequest;

class CreditStoreRequest extends FormRequest {

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

            'title'        => 'required|string',
            'currency'     => 'required|string',
            'creditor'     => 'required|string',
            'start_date'   => 'required|string',
            'payment_date' => 'required|string',
            'amount'       => [
                'required',
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
            'percent'      => [
                'required',
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
            'period'       => 'integer',
            'payment'      => [
                'required',
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
        ];
    }
}
