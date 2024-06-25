<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class MemberLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'=>'required|email',
            'password'=>'required',
        ];
    }
    public function messages()
    {
        return[
            'required'=>':attribute is required',
            'email'=>':attribute requires a valid email format',
        ];
    }
    public function attributes()
    {
        return[
            'email'=>'The email',
            'password'=>'The password',
        ];
    }
}