<?php

namespace App\Http\Requests\admin\profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'email'=>'required|email',
            'avatar'=>'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'required'=>':attribute is required',
            'email'=>':attribute requires a valid email format',
            'image'=>':attribute is required to be an image',
            'mimes'=>':attribute must have the extension :values',
            'avatar.max'=>':attribute is required to be no larger than :max'
        ];
    }
    public function attributes()
    {
        return[
            'name'=>'The name',
            'email'=>'The email',
            'avatar'=>'The uploaded file',
        ];
    }
}