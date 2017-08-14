<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Request;

class AddDistributor extends FormRequest
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
            'aadhar'                =>  'required|string|max:20',
            'accountNumber'         =>  'required|numeric',
            'address'               =>  'required|string|max:100',
            'bankBranch'            =>  'required|string|max:20',
            'bankName'              =>  'required|numeric',
            'email'                 =>  'required|email',
            'gps'                   =>  'nullable',
            'mobile'                =>  'required|numeric|digits_between:5,10',
            'password'              =>  'required|string|max:30|min:6',
            'passwordConfirmation'  =>  'required|same:password',
            'shopName'              =>  'required|string|max:30',
            'username'              =>  'required|string|max:20'
        ];
    }
}
