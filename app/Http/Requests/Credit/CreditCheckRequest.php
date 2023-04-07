<?php

namespace App\Http\Requests\Credit;

use App\Libs\CreditSubject;
use Illuminate\Foundation\Http\FormRequest;

class CreditCheckRequest extends FormRequest {

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
            'amount'       => [
                "required",
                "regex:/^\d+(\.\d{1,2})?$/",
            ],
            'percent'      => [
                "required",
                "regex:/^\d+(\.\d{1,2})?$/",
            ],
            'period'       => [
                "required",
                "integer",
            ],
            'payment'      => [
                "required",
                "regex:/^\d+(\.\d{1,2})?$/",
            ],
        ];
    }
}
