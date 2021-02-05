<?php

namespace App\Http\Requests\Frontend\Agent;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewAgent extends FormRequest
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
            'email' => 'required|email|unique:agents',
            'password' => 'required|min:6'
        ];
    }
}
