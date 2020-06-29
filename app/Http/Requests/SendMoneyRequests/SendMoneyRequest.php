<?php

namespace App\Http\Requests\SendMoneyRequests;

use App\Http\Requests\BaseFormRequest;
use App\User;
use Illuminate\Validation\Rule;

class SendMoneyRequest extends BaseFormRequest
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
        $admin_id=request('admin_id');
        return [
            'admin_id'=>['required', Rule::exists('users','id')->where(function ($query) {
                $query->where('role', 0);
            })],
            'phone_number' => 'required|exists:users,phone',
            'amount' => ['required','numeric', static function ($attribute, $value, $fail) use ($admin_id) {
                if ($admin_id){
                    $user=User::whereHas('wallet',function ($q) use ($admin_id){
                            $q->where('user_id', $admin_id);
                    })->first();
                    if ($user){
                        if ($value > $user->wallet->current_balance) {
                            $fail($attribute.' is invalid.');
                        }
                    }else{
                        $fail($attribute.' is invalid.');
                    }
                }else{
                    $fail($attribute.' is invalid.');
                }
            }],
            'pin' => ['required', Rule::exists('users','pin')->where(function ($query) {
                $query->where('phone', request('phone_number'));
            })],
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
            'phone_number' => 'escape|trim',
            'amount' => 'escape|digit|trim',
            'pin' => 'escape|digit|trim'
        ];
    }
}
