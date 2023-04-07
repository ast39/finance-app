<?php

namespace App\Http\Requests\Credit;

use App\Libs\CreditSubject;
use Illuminate\Foundation\Http\FormRequest;

class CreditCalcRequest extends FormRequest {

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
            'subject'      => 'required|string',
            'currency'     => 'required|string',
            'amount'       => [
                "required_if:subject, !=, " . CreditSubject::AMOUNT,
                "regex:/^\d+(\.\d{1,2})?$/",
            ],
            'percent'      => [
                "required_if:subject, !=, " . CreditSubject::PERCENT,
                "regex:/^\d+(\.\d{1,2})?$/",
            ],
            'period'       => [
                "required_if:subject, !=, " . CreditSubject::PERIOD,
                "integer",
            ],
            'payment'      => [
                "required_if:subject, !=, " . CreditSubject::PAYMENT,
                "regex:/^\d+(\.\d{1,2})?$/",
            ],
            'payment_type' => 'required|integer',
        ];
    }
}
