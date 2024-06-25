<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class ProductAddRequest extends FormRequest
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
            'brand'=>'required',
            'name'=>'required|max:50|min:5',
            'file'=>'required',
            'file.*'=>'image|mimes:jpeg,png,jpg',
            'price'=>'required|integer',
            'detail'=>'required', 
            'company'=>'required',
        ];
    }
    public function messages()
    {
        return[
            'required'=>':attribute is required',
            'max'=>':attribute can not more than :max character',
            'min'=>':attribute can not less than :min character',
            'integer'=>':attribute only accepts number',
            'image'=>'Image only allow image file',
            'mimes'=>'Image must be a file of type :values',
        ];
    }
}