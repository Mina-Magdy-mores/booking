<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
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
            'location' => 'sometimes|required|string|min:3',
            'start_date' => 'sometimes|required|date',
            'ended_date' => 'sometimes|required|date',
            'price' => 'sometimes|required|decimal:2|min:0',
            'available_seats' => 'sometimes|required|integer|min:0',
            'is_active' => 'boolean',
            'image' => 'sometimes|array',
            'image.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:20048',
            'category_id' => 'sometimes|required|integer|exists:categories,id',
        ];
    }
}
