<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Patient;
use App\Models\AppointmentSlot;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
     /**
     * Bemorlarni qidirish (AJAX uchun)
     */
    public function searchPatients(Request $request)
    {
        // dd($request);
        $searchTerm = $request->get('q', '');
        $searchType = $request->get('type', 'passport');
        
        $query = Patient::with('user');
        
        if ($searchType === 'name') {
            $query->whereHas('user', function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('last_name', 'like', "%{$searchTerm}%")
                  ->orWhere(DB::raw("CONCAT(last_name, ' ', name)"), 'like', "%{$searchTerm}%");
            });
        } 
        elseif ($searchType === 'passport') {
            $query->where(function($q) use ($searchTerm) {
                $q->where('passport_series', 'like', "%{$searchTerm}%")
                  ->orWhere('passport_number', 'like', "%{$searchTerm}%")
                  ->orWhere(DB::raw("CONCAT(passport_series, passport_number)"), 'like', "%{$searchTerm}%");
            });
        }
        
        $patients = $query->limit(20)->get();
        
        $result = [];
        foreach ($patients as $patient) {
            $result[] = [
                'id' => $patient->id,
                'name' => ($patient->user->last_name ?? '') . ' ' . ($patient->user->name ?? ''),
                'passport_series' => $patient->passport_series ?? '',
                'passport_number' => $patient->passport_number ?? '',
                'passport_full' => trim(($patient->passport_series ?? '') . ' ' . ($patient->passport_number ?? '')),
                'birth_date' => $patient->birth_date ? Carbon::parse($patient->birth_date)->format('Y-m-d') : '',
                'birth_date_formatted' => $patient->birth_date ? Carbon::parse($patient->birth_date)->format('d.m.Y') : '',
                'age' => $patient->birth_date ? Carbon::parse($patient->birth_date)->age : '',
                'phone' => $patient->user->phone ?? '',
            ];
        }
        
        return response()->json($result);
    }

    /**
     * Kutilayotgan qabulni rad etish (appointmentni ochish)
     * Slot statusi available bo'ladi, appointment o'chiriladi
     */
    public function cancelBookedAppointment(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $slotId = $request->slot_id;
            $slot = AppointmentSlot::with('appointment')->findOrFail($slotId);
            
            if (!$slot->appointment) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bu slotda appointment mavjud emas'
                ], 404);
            }
            
            // Appointmentni o'chirish (yoki statusini o'zgartirish)
            $slot->appointment->delete();
            
            // Slot statusini available qilish
            $slot->status = 'available';
            $slot->patient_id = null;
            $slot->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Qabul rad etildi va slot bo\'sh qilindi',
                'slot_id' => $slot->id,
                'new_status' => 'available'
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Cancel pending appointment error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Xatolik yuz berdi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Qabul yaratish (AJAX POST)
     */
    public function storeAppointment(Request $request)
    {
        try {
            $request->validate([
                'slot_id' => 'required|exists:appointment_slots,id',
                'patient_id' => 'required|exists:patients,id',
                'reason' => 'required|string|min:3|max:500',
                'complaint_duration' => 'nullable|string|max:100',
            ]);
            
            $slot = AppointmentSlot::findOrFail($request->slot_id);
            
            if ($slot->status !== 'available') {
                return response()->json(['success' => false, 'message' => 'Bu vaqt allaqachon band qilingan'], 422);
            }
            
            $appointment = Appointment::create([
                'appointment_slot_id' => $slot->id,
                'patient_id' => $request->patient_id,
                'doctor_id' => 1,
                'reason' => $request->reason,
                'notes' => $request->complaint_duration,
                'status' => 'booked',
                'date' => now(),
                'treatment_type' => 'inpatient',
            ]);
            
            $slot->update(['status' => 'booked']);
            
            return response()->json([
                'success' => true,
                'message' => 'Qabul muvaffaqiyatli yaratildi',
                'appointment' => $appointment
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Xatolik: ' . $e->getMessage()
            ], 500);
        }
    }
    

    public function create() 
    {
        return view('dashboard.receptionist.patient-create');
    }

    public function store(Request $request)
    {
        // dd($request);
        try {
            // Validatsiya
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'last_name' => 'required|string|max:255',
                'login' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'phone' => 'required|string|max:20', 
                'birth_date' => 'required|date|before:today',
                'gender' => 'required|in:male,female',
                'passport_series' => 'required|string|max:2',
                'passport_number' => 'required|string|max:7',
                'address' => 'nullable|string|max:500',
            ]);
    
            // Tug'ilgan sana bo'yicha yoshni tekshirish (18 yoshdan katta)
            $birthDate = new \DateTime($validated['birth_date']);
            $today = new \DateTime();
            $age = $today->diff($birthDate)->y; 
    
            // Telefon raqamini formatlash (bo'shliqlarni olib tashlash)
            $phone = preg_replace('/\s+/', '', $validated['phone']);
    
            // Oxirgi user loginni olish
            $lastUser = User::orderBy('id', 'desc')->first();
            $newLogin = $lastUser ? $lastUser->login + 1 : 100001;
    
            DB::beginTransaction();
    
            // 1. Avval User yaratish
            $user = User::create([
                'name' => $validated['name'] . ' ' . $validated['last_name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'],
                'login' => $newLogin,
                'email' => $validated['email'] ?? $this->generateUniqueEmail($validated['name'], $validated['last_name']),
                'phone' => $phone,  
                'password' => Hash::make($request->password_number), 
            ]);

            $user->roles()->attach([3]);
    
            // 2. Keyin Patient yaratish
            $patient = Patient::create([ 
                'user_id' => $user->id,
                'birth_date' => $validated['birth_date'],
                'gender' => $validated['gender'],
                'passport_series' => strtoupper($validated['passport_series']),
                'passport_number' => $validated['passport_number'],
                'address' => $validated['address'] ?? null,
            ]);
    
            DB::commit();
    
            return redirect()
                ->route('receptionist.index')
                ->with('success', 'Bemor muvaffaqiyatli qo\'shildi! Login: ' . $newLogin);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withInput()
                ->withErrors($e->errors());
    
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Xatolikni logga yozish
            Log::error('Patient store error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
    
            return back()
                ->withInput()
                ->with('error', 'Bemor qo\'shishda xatolik yuz berdi! Xatolik: ' . $e->getMessage());
        }
    }

    /**
     * Generate unique email
     */
    private function generateUniqueEmail($name, $lastName)
    {
        $baseEmail = strtolower($name . '.' . $lastName . '@patient.com');
        $email = $baseEmail;
        $counter = 1;
        
        while (User::where('email', $email)->exists()) {
            $email = strtolower($name . '.' . $lastName . $counter . '@patient.com');
            $counter++;
        }
        
        return $email;
    }
}
