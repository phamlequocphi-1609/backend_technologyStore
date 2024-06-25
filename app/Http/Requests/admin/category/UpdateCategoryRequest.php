<?php

namespace App\Http\Requests\admin\category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'category'=>'required',
            'image'=>'image|mimes:jpeg,png,jpg|max:2048'
        ];
    }
    public function messages()
    {
        return[
            'required'=>':attribute is required',
            'image'=>':attribute is required to be an image',
            'max'=>':attribute is required to be no larger than :max',
            'mimes'=>':attribute must have the extension :values',
        ];
    }
    public function attributes()
    {
        return[
            'category'=>'The category',
            'image'=>'The uploaded file'
        ];
    }
}