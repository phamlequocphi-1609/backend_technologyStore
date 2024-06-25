<?php

namespace App\Http\Requests\admin\country;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
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
        ];
    }
    public function messages(): array
    {
        return [
            'required'=>':attribute is required',
        ];
    }
    public function attributes()
    {
        return[
            'name'=>'Name',
        ];
    }
}