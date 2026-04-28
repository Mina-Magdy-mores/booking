<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdataCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|min:3',
            'description' => 'nullable|string|min:3',
            'is_active' => 'boolean',
        ];
    }
    public function messages(): array
    {
        return [
            'title.sometimes' => 'The title field is sometimes required.',
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.min' => 'The title must be at least 3 characters.',
            'description.string' => 'The description must be a string.',
            'description.min' => 'The description must be at least 3 characters.',
            'is_active.boolean' => 'The is_active field must be a boolean.',
        ];
    }
}
