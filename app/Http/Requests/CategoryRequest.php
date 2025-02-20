<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Category name is required',
            'name.max' => 'Category name cannot exceed 255 characters',
            'type.required' => 'Category type is required',
            'type.in' => 'Category type must be either income or expense',
        ];
    }
} 