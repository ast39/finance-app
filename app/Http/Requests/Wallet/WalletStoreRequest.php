<?php

namespace App\Http\Requests\Wallet;

use Illuminate\Foundation\Http\FormRequest;

class WalletStoreRequest extends FormRequest {

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

            'currency'    => 'required|string',
            'title'       => 'required|string|unique:wallets',
            'note'        => 'string|nullable',
            'amount'      => [
                'required',
                'regex:/^[-+]?\d+(\.\d{1,2})?$/',
            ],
        ];
    }
}
