<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
          'user_id' => 'required|string|exists:users,id',
          'event_id' => 'required|string|exists:events,id',
          'quantity' => 'required|integer|min:1',
          'total_price' => 'required|numeric|min:0',
          'status' => 'required|string|in:pending,confirmed,cancelled',
        ];
    }
}
