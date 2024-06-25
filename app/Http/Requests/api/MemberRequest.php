<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required',
            'phone'=>'required',
            'avatar'=>'image|mimes:jpeg,png,jpg,gif|max:2048',
            'address'=>'required',
            'country'=>'required',
            'level'
        ];
    }
    public function messages()
    {
        return[
            'required'=>':attribute is required',
            'email'=>':attribute requires a valid email format',
            'email.unique'=>':attribute address already exists',
            'avatar.max'=>':attribute is required to be no larger than :max',
            'image'=>':attribute is required to be an image',
            'mimes'=>':attribute must have the extension :values',
        ];
    }
    public function attributes()
    {
        return[
            'name'=>'The name',
            'email'=>'The email',
            'password'=>'The password',
            'phone'=>'The phone number',
            'avatar'=>'The uploaded file',
            'address'=>'The address',
            'country'=>'The country'
        ];
    }
}