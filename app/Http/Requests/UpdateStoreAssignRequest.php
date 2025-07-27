<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStoreAssignRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $assignment = $this->route('assignment');
        
        return [
            
            'room_id' => 'required|exists:rooms,id',
            // 'trx_no' => 'required|string|max:255|unique:assignments,trx_no',
            'trx_no' => [
                'required',
                'string',
                'max:255',
                Rule::unique('assignments', 'trx_no')->ignore($assignment->id),
            ],
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'guests' => 'required|array|min:1',
            'guests.*.name' => 'required|string|max:255',
            'guests.*.treatment_id' => 'required|exists:treatments,id',
            'guests.*.therapist_id' => 'required|exists:therapists,id',
            'guests.*.duration_in_min' => 'required|integer|min:30|max:180',

            'guests.*.products' => 'nullable|array',
            'guests.*.products.*' => 'nullable|integer|exists:products,id',
        ];
    }

    public function messages(): array
{
    return [
        'guests.*.duration_in_min.min' => 'Duration must be at least 30 minutes.',
        'guests.*.duration_in_min.max' => 'Duration cannot exceed 180 minutes.',
    ];
}
}
