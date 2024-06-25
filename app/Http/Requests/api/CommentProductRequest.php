<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;

class CommentProductRequest extends FormRequest
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
            'id_product'=>'required',
            'id_user'=>'required',
            'name_user'=>'required',
            'avatar_user'=>'required',
            'comment'=>'required',
            'id_comment'=>'required',
        ];
    }
    public function messages()
    {
        return[
            'id_product.required'=>':attribute is required',
            'id_user.required'=>':attribute is required',
            'name_user.required'=>':attribute is required',
            'avatar_user.required'=>':attribute is required',
            'comment.required'=>':attribute is required',
            'id_comment.required'=>':attribute is required',
        ];
    }
}