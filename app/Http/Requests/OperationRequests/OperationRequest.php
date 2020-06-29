<?php

namespace App\Http\Requests\OperationRequests;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Support\Str;

class OperationRequest extends BaseFormRequest
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
            'state' => 'required|in:1,0', //pending 0 , active 1
            'amount' => 'required|numeric',
            'title' => 'required|string|min:3|max:255',
            'phone_number' => 'required',
            'description' => 'string|min:3|max:500',
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
            'state.required' => 'state is required',
            'amount.required' => 'amount is required',
            'title.required' => 'title is required',
            'phone_number.required' => 'phone is required',
            'description.required' => 'description must be string | min 3 characters',
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
            'state' => 'escape|digit|trim',
            'amount' => 'escape|trim',
            'title' => 'escape|lowercase|trim',
            'phone_number' => 'escape|trim',
            'description' => 'trim|escape|lowercase',
        ];
    }
}
