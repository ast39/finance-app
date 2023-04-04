<?php

namespace App\Http\Requests\Wallet\Payment;

use Illuminate\Foundation\Http\FormRequest;

class WalletPaymentUpdateRequest extends FormRequest {

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

            'note'      => 'string|nullable',
            'amount'    => 'required|numeric',
        ];
    }
}
