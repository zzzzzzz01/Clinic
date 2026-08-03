<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Yoki auth()->check()
    }
    
    public function rules()
    {
        return [
            'selected_tests' => 'required|string',
            'hospitalization_id' => 'required|integer|exists:hospitalizations,id',
            'ordered_by' => 'required|integer|exists:users,id',
            'order_type' => 'required|string|in:normal,urgent,emergency',
            'order_date' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
        ];
    }
    
    public function messages()
    {
        return [
            'selected_tests.required' => 'Testlar majburiy',
            'selected_tests.string' => 'Testlar formati noto\'g\'ri',
            'hospitalization_id.required' => 'Gospitalizatsiya ID majburiy',
            'hospitalization_id.exists' => 'Gospitalizatsiya topilmadi',
            'ordered_by.required' => 'Buyurtmachi majburiy',
            'ordered_by.exists' => 'Buyurtmachi topilmadi',
            'order_type.required' => 'Buyurtma turi majburiy',
            'order_type.in' => 'Buyurtma turi noto\'g\'ri',
            'notes.max' => 'Izoh 1000 belgidan oshmasligi kerak',
        ];
    }
}