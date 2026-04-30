<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
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
            'title' => 'required|string|min:3',
            'description' => 'nullable|string|min:3',
            'location' => 'required|string|min:3',
            'start_date' => 'required|date',
            'ended_date' => 'required|date',
            'price' => 'required|decimal:2|min:0',
            'available_seats' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'image' => 'required|array',
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:20048',
            'category_id' => 'required|integer|exists:categories,id',
        ];
    }
}
