<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\PrescriptionItem;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function store(Request $request)
    {
        // dd($request);
        try {
            $request->validate([
                'appointment_id' => 'required|exists:appointments,id',
                'doctor_id' => 'required|exists:doctors,id',
                'patient_id' => 'required|exists:patients,id',
                'medications' => 'required|array',
                'medications.*.medicine_id' => 'required|exists:medicines,id',
                'medications.*.dosage' => 'nullable|string|max:100',
                'medications.*.form' => 'nullable|string|max:50',
                'medications.*.frequency_type' => 'required',
                'medications.*.frequency_value' => 'nullable',
                'medications.*.dosage_amount' => 'required|string|max:100',
                'medications.*.usage' => 'required|string',
                'medications.*.duration' => 'required|integer|min:1',
                'medications.*.note' => 'nullable|string',
            ]);
    
            // Prescription yaratish
            $prescription = Prescription::create([
                'doctor_id' => $request->doctor_id,
                'patient_id' => $request->patient_id,
                'appointment_id' => $request->appointment_id,
                'prescription_date' => now(),
                'status' => 'active',
            ]);
    
            // Prescription items (dorilar) ni saqlash
            foreach ($request->medications as $medication) {
                $frequencyValue = null;
                
                if (!in_array($medication['frequency_type'], ['as_needed', 'once'])) {
                    $frequencyValue = $medication['frequency_value'] ?? null;
                }
                
                PrescriptionItem::create([
                    'prescription_id' => $prescription->id,
                    'medicine_id' => $medication['medicine_id'],
                    'frequency_type' => $medication['frequency_type'],
                    'frequency_value' => $frequencyValue,
                    'dose_amount' => $medication['dosage_amount'],
                    'duration_days' => $medication['duration'],
                    'usage_instructions' => $medication['usage'],
                    'note' => $medication['note'] ?? null,
                ]);
            }
    
            // JSON RESPONSE QAYTARISH (JavaScript uchun)
            return response()->json([
                'success' => true,
                'message' => 'Retsept muvaffaqiyatli saqlandi!',
                'prescription_id' => $prescription->id,
                'prescriptions' => $this->getPrescriptionsByAppointment($request->appointment_id)
            ]);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation xatosi: ' . implode(', ', $e->errors())
            ], 422);
            
        } catch (\Exception $e) {
            \Log::error('Prescription save error: ' . $e->getMessage());
            \Log::error('Request data: ', $request->all());
            
            return response()->json([
                'success' => false,
                'message' => 'Xatolik: ' . $e->getMessage()
            ], 500);
        }
    }
    
    // GET BY APPOINTMENT - Retseptlarni olish
    public function getByAppointment($appointmentId)
    {
        try {
            $prescriptions = $this->getPrescriptionsByAppointment($appointmentId);
            
            return response()->json([
                'success' => true,
                'prescriptions' => $prescriptions
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    // Yordamchi funksiya
    private function getPrescriptionsByAppointment($appointmentId)
    {
        $prescriptions = Prescription::where('appointment_id', $appointmentId)
            ->with('items.medicine')
            ->get();
        
        $result = [];
        foreach ($prescriptions as $prescription) {
            foreach ($prescription->items as $item) {
                $result[] = [
                    'id' => $item->id,
                    'prescription_id' => $prescription->id,
                    'medicine_id' => $item->medicine_id,
                    'medicine_name' => $item->medicine ? $item->medicine->name : 'Noma\'lum',
                    'name' => $item->medicine ? $item->medicine->name : 'Noma\'lum',
                    'dosage' => $item->medicine ? $item->medicine->strength_value . ' ' . $item->medicine->strength_unit : '-',
                    'form' => $item->medicine ? $item->medicine->form : '-',
                    'frequency_type' => $item->frequency_type,
                    'frequency_value' => $item->frequency_value,
                    'dosage_amount' => $item->dose_amount,
                    'usage_text' => $item->usage_instructions,
                    'duration_days' => $item->duration_days,
                    'note' => $item->note,
                ];
            }
        }
        
        return $result;
    }
}