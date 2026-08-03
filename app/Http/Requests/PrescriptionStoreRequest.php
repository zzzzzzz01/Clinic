<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrescriptionStoreRequest extends FormRequest
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
        return [
            'medicine_id' => 'required|exists:medicines,id',
            'frequency_type' => 'required|in:daily,hourly,weekly,interval,once,as_needed',
            'frequency_value' => 'nullable|integer',
            'dosage_amount' => 'required|string',
            'duration_days' => 'required|integer|min:1',
            'prescribed_by_type' => 'required|in:doctor,nurse',
            'prescribed_by_id' => 'required|integer',
            'start_at' => 'required|date',
            'note' => 'nullable|string',
            'dosage' => 'nullable|string',
            'form' => 'nullable|string',
        ];
    }
}
