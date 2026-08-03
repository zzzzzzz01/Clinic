<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HospitalizationProcedureStoreRequest extends FormRequest
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
            'patient_id' => 'required|exists:patients,id',
            'hospitalization_id' => 'required|exists:hospitalizations,id',
            'staff_id' => 'required|string',
            'procedure_id' => 'required|exists:procedures,id',
            'room_id' => 'required|exists:rooms,id',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'patient_id.required' => 'Bemor tanlanishi shart',
            'patient_id.exists' => 'Bemor topilmadi',
            'hospitalization_id.required' => 'Gospitalizatsiya tanlanishi shart',
            'hospitalization_id.exists' => 'Gospitalizatsiya topilmadi',
            'staff_id.required' => 'Xodim tanlanishi shart',
            'procedure_id.required' => 'Protsedura tanlanishi shart',
            'procedure_id.exists' => 'Protsedura topilmadi',
            'room_id.required' => 'Xona tanlanishi shart',
            'room_id.exists' => 'Xona topilmadi',
            'notes.max' => 'Izoh 1000 belgidan oshmasligi kerak',
        ];
    }
}
