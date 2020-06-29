<?php

namespace App\Http\Requests\FriendRequests;

use App\Http\Requests\BaseFormRequest;

class FriendRequest extends BaseFormRequest
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
            'id'=>'numeric|exists:friends,id',
            'phone_number' => 'required|string|unique:friends,phone_number,'.request()->id,
            'full_name' => 'required|string|max:255|min:3',
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
            'phone_number.required' => 'phone number is required',
            'phone_number.unique' => 'phone number must be unique',
            'full_name.required' => 'name is required',
            'full_name.min' => 'name is min 3 char',
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
            'phone_number'  => 'trim|escape',
            'full_name'  =>  'trim|escape|lowercase'
        ];
    }
}
