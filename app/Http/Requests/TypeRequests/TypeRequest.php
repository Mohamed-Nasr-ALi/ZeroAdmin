<?php

namespace App\Http\Requests\TypeRequests;

use App\Http\Requests\BaseFormRequest;

class TypeRequest extends BaseFormRequest
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
            'state' => 'required|in:1,0', // 1  active , 2 disactive
            'type_name' => 'required|string|max:255|min:3',
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
            'state.required' => 'State is Required (note: value must in [1,0])',
            'type_name.required' => 'Type Name is Required',
            'type_name.min' => 'Type Name is min 3 char',
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
            'type_name'  => 'trim|lowercase',
        ];
    }
}
