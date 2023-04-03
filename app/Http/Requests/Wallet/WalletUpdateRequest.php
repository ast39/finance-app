<?php

namespace App\Http\Requests\Wallet;

use Illuminate\Foundation\Http\FormRequest;

class WalletUpdateRequest extends FormRequest {

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

            'title'       => 'string|unique:wallets,title,' . $this->id . ',wallet_id',
            'note'        => 'string',
            'amount'      => 'numeric',
            'status'      => 'integer',
        ];
    }
}
