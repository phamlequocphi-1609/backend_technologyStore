<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class RateBlogRequest extends FormRequest
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
            'id_blog'=>'required',
            'id_user'=>'required',
            'rate'=>'required',
        ];
    }
    public function messages()
    {
        return [
            'required'=>':attribute is required',
        ];
    }
    public function attributes()
    {
        return[
            'id_blog'=>'id_blog',
            'id_user'=>'id_user',
            'rate'=>'The rate',
        ];
    }
}