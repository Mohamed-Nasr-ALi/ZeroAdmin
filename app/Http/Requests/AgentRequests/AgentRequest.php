<?php

namespace App\Http\Requests\AgentRequests;

use App\Http\Requests\BaseFormRequest;

class AgentRequest extends BaseFormRequest
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
        if (request('user_id')){
            return [
                'user_id'=>'required|numeric|exists:users,id',
                'agent_id'=>'required|numeric|exists:agents,id',
                'cashback_id'=>'required|numeric|exists:cashbacks,id',
                'type_id' => 'required|numeric|exists:types,id',
                'business_name' => 'required|string|max:255|min:3',
                'business_type' => 'required|numeric|in:1,-1,2', //1 pos , -1 pur , 2 pos & pur
                'business_logo' => 'image|max:51200',
                'client_cashback' => 'numeric',
                'zerocach_cashback' => 'required|numeric',
                'full_name' => 'required|string',
                'phone' => 'required|string|unique:users,phone,'.request()->user_id,
                'email' => 'required|string|unique:users,email,'.request()->user_id,
                'password' => 'required|string|min:8',
                'pin' => 'required|string|max:4|min:4',
            ];
        }else{
            return [
                'type_id' => 'required|numeric|exists:types,id',
                'business_name' => 'required|string|max:255|min:3',
                'business_type' => 'required|numeric|in:1,-1,2', //1 pos , -1 pur , 2 pos & pur
                'business_logo' => 'image|max:51200',
                'client_cashback' => 'numeric|max:255',
                'zerocach_cashback' => 'required|numeric|max:255',
                'full_name' => 'required|string',
                'phone' => 'required|string|unique:users,phone',
                'email' => 'required|string|unique:users,email',
                'password' => 'required|string|min:8',
                'pin' => 'required|string|max:4|min:4',
            ];
        }

    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'type_id.required' => 'Type is Required',
            'business_name.required' => 'Business Name is Required',
            'business_logo.max' => 'max size 51200',
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
            'type_id' => 'escape|digit|trim',
            'user_id' => 'escape|digit|trim',
            'agent_id' => 'escape|digit|trim',
            'business_name'  => 'trim|lowercase',
            'business_type'  =>  'escape|trim',
            'client_cashback' => 'escape|trim',
            'zerocach_cashback' => 'escape|trim',
            'full_name'=>'escape|lowercase|trim',
            'email'=>'trim|escape',
            'password'=>'trim|escape',
            'phone'=>'trim|escape',
            'pin'=>'trim|escape',
        ];
    }
}
