<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class MemberUpdateRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name'=>'required|max:191',
            'email' => 'required|email',
            'address'=>'required',
            'phone'=>'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'required'=>':attribute is required',
            'max'=>':attribute is required to be no larger than :max character',
            'image' => ':attribute is required to be an image',
            'mimes' => ':attribute must have the extension :jpeg,png,jpg,gif',
            'image.max' => ':attribute Maximum file size to upload :max'
        ];
    }
    public function attributes()
    {
        return[
            'name'=>'The name',
            'email'=>'The email',
            'address'=>'The address',
            'phone'=>'The phone',
            'image'=>'The upload file'
        ];
    }
}