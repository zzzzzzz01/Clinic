<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Diagnose;
use App\Models\Appointment;
use App\Models\Hospitalization;
use App\Models\AppointmentSlot;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache; // Cache ni qo'shing

class DiagnoseController extends Controller
{
    // Agar doctorService kerak bo'lsa, constructorda yuklang
    // yoki uni o'chirib tashlang
    
    public function clearDoctorsCache(): void
    {
        Cache::tags(['doctors'])->flush();
    }

    public function store(Request $request, Appointment $appointment)
    {
        try {
            $validated = $request->validate([
                'diagnosis'        => 'required|string|max:255',
                'full_diagnosis'   => 'required|string',
                'appointment_id'   => 'required|exists:appointments,id',
                'treatment_type'   => 'required|in:outpatient,inpatient',
                'department_id'    => 'nullable|exists:departments,id',
                'urgency'          => 'required_if:treatment_type,inpatient|in:normal,urgent,emergency',
                'recommendations'  => 'nullable|string',
                'referral_reason'  => 'required_if:treatment_type,inpatient',
                'slot_id'          => 'required|exists:appointment_slots,id', // BU QO'SHILDI
            ]);
    
            DB::beginTransaction();
    
            // Appointmentni yangilash
            $appointment->update([
                'treatment_type'  => $request->treatment_type,
                'status'          => 'completed',
            ]);
    
            // Slotni yangilash
            $slot = AppointmentSlot::findOrFail($request->slot_id);
            $slot->update([
                'status' => 'completed',
            ]);
    
            // Diagnosis jadvaliga yozish
            Diagnose::create([
                'appointment_id' => $appointment->id,
                'diagnosis'      => $request->diagnosis,
                'full_diagnosis' => $request->full_diagnosis,
                'complaints'     => $appointment->reason,
                'recommendations'=> $request->recommendations,
            ]);
    
            // Agar kasalxonaga yotqizish bo'lsa
            if ($request->treatment_type === 'inpatient') {
                Hospitalization::create([
                    'appointment_id' => $appointment->id,
                    'department_id'  => $request->department_id,
                    'referral_reason'=> $request->referral_reason,
                    'urgency'        => $request->urgency,
                    'status'         => 'waiting_for_bed',
                ]);
            }
    
            DB::commit();
            
            // Cache tozalash - to'g'rilangan
            $this->clearDoctorsCache(); // yoki self::clearDoctorsCache()
    
            $date = Carbon::parse($appointment->date)->format('Y-m-d');
    
            return redirect()->route('doctor.appointments', ['date' => $date])
                            ->with('success', __('words.consultation_saved_successfully'));
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack(); // Validation xatosida rollback qilish shart emas, lekin qo'shish mumkin
            return redirect()->back()
                             ->withErrors($e->validator)
                             ->withInput()
                             ->with('error', __('words.please_fill_fields_correctly'));
                             
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Konsultatsiya saqlashda xatolik: ' . $e->getMessage(), [
                'appointment_id' => $appointment->id,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString() // Trace ham qo'shing
            ]);
            
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Xatolik: ' . $e->getMessage()); // Xatolikni ko'rsatish uchun
        }
    }
}