<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PrescriptionAdministrationRequest extends FormRequest
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
            'slots' => 'nullable|array',
            'slots.*.hospitalization_prescription_item_id' => 'required_with:slots|exists:hospitalization_prescription_items,id',
            'slots.*.slot_id' => 'required_with:slots|exists:hospitalization_prescription_item_slots,id',
            'slots.*.status' => 'required_with:slots|in:pending,given,skipped,stopped,resumed',
            'slots.*.skip_reason' => 'nullable|string',
    
            'administrations' => 'nullable|array',
            'administrations.*.hospitalization_prescription_item_id' => 'required_with:administrations|exists:hospitalization_prescription_items,id',
            'administrations.*.slot_id' => 'nullable|exists:hospitalization_prescription_item_slots,id',
            'administrations.*.scheduled_date' => 'required_with:administrations|date',
            'administrations.*.scheduled_time' => 'required_with:administrations',
            'administrations.*.status' => 'required_with:administrations|in:pending,given,skipped,stopped,resumed',
            'administrations.*.skip_reason' => 'nullable|string',
        ];
    }
}
