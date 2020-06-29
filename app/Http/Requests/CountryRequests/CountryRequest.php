<?php

namespace App\Http\Requests\CountryRequests;

use App\Http\Requests\BaseFormRequest;

class CountryRequest extends BaseFormRequest
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
        if (request('country_id')){
            return [
                'country_id'=>'numeric|exists:countries,id',
                'calling_code' =>'required|numeric|min:1|max:255|unique:countries,calling_code,'.request('country_id'),
                'currency_name' =>'string|max:255',
                'currency_code' => 'required|string|max:255',
                'currency_symbol' => 'required|string|max:255',
                'country_name_ar' =>'required|min:3|max:255|unique:countries,country_name_ar,'.request('country_id'),
                'country_name_en' => 'required|min:3|max:255|unique:countries,country_name_en,'.request('country_id'),
                'flag'=>'required|max:255|unique:countries,flag,'.request('country_id'),
            ];
        }else{
            return [
                'country_id'=>'numeric|exists:countries,id',
                'calling_code' =>'required|numeric|min:1|max:255|unique:countries,calling_code',
                'currency_name' =>'string|max:255',
                'currency_code' => 'required|string|max:255',
                'currency_symbol' => 'required|string|max:255',
                'country_name_ar' =>'required|min:3|max:255|unique:countries,country_name_ar',
                'country_name_en' => 'required|min:3|max:255|unique:countries,country_name_en',
                'flag'=>'required|max:255|unique:countries,flag',
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
            'calling_code' =>'escape|digit|trim',
            'currency_name' =>'escape|trim',
            'currency_code' =>'escape|trim',
            'currency_symbol' => 'escape|trim',
            'country_name_ar' =>'escape|trim|lowercase',
            'country_name_en' => 'escape|trim|lowercase',
            'flag'=>'escape|trim',
        ];
    }
}
