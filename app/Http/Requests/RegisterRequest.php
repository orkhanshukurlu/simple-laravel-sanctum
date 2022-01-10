<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

            'name'     => 'required|max:30',
            'email'    => 'required|email|unique:users|max:40',
            'password' => 'required|min:5'
        ];
    }
}