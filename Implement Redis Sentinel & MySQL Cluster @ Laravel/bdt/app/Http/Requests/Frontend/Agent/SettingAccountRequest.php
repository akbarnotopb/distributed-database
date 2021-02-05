<?php

namespace App\Http\Requests\Frontend\Agent;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SettingAccountRequest extends FormRequest
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
            'firstname' => 'required',
            'email' => [
                'required', 'email', Rule::unique('agents')->ignore(auth()->id())
            ],
            'phone_number' => [
                'required', 'min:8', 'regex:/(08|\+628)([0-9]+)/'
            ],
            'nik' => [
                'required', 'min:16', 'regex:/([0-9]+)/'
            ],
            'address' => 'required',
            'username' => ['sometimes','required','alpha_num',Rule::unique('agents')->ignore(auth()->id())],
            'whatsapp' => 'nullable|numeric|min:8'
            // 'phone_number_of_parent' => 'required|min:8|regex:/(08)([0-9]+)/',
            //'avatar' => 'image|mimes:jpeg,jpg,png,bmp,svg|max:10000'
        ];
    }

    public function messages(){
        return [
            'email.unique' => 'Email sudah terdaftar, gunakan email lainnya!',
            'username.unique' => 'Username sudah terdaftar, gunakan username lainnya!',
            'username.alpha_num' =>'Username hanya boleh terdiri dari Alphanumeric!'
        ];
    }
}
