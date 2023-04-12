<?php

namespace App\Http\Requests\Wallet\Payment;

use Illuminate\Foundation\Http\FormRequest;

class WalletPaymentStoreRequest extends FormRequest {

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

            'wallet_id' => 'required|integer',
            'note'      => 'string|nullable',
            'amount'    => [
                'required',
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
        ];
    }
}
