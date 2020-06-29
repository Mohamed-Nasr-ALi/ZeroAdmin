<?php

namespace App\Http\Requests\WalletRequests;

use App\Http\Requests\BaseFormRequest;

class WalletRequest extends BaseFormRequest
{
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
     * @return array
     */
    public function rules()
    {

        return [
            'current_balance' => 'required|numeric',
            'cashback' => 'required|numeric',
            'total_spint' => 'required|numeric',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'current_balance.required' => 'current balance is Required',
            'cashback.required' => 'cashback  is Required',
            'total_spint.required' => 'total spint  is Required'
        ];
    }

    /**
     *  Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        return [
            'current_balance' => 'escape|trim',
            'cashback'  => 'escape|trim',
            'total_spint'  => 'escape|trim',
        ];
    }
}
