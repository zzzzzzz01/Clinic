<?php

namespace App\Services; 

use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\AppointmentSlot;
use Carbon\Carbon;

class PageService
{
    /**
     * Personal data uchun ma'lumotlarni tayyorlash
     */
    public function getPersonalData()
    {
        $user = auth()->user();
        $profile = $user->profile;

        // Avatar uchun harflar
        $firstNameInitial = substr($user->name, 0, 1);
        $lastNameInitial = substr($user->last_name, 0, 1);
        $avatarLetters = $firstNameInitial . $lastNameInitial;

        // Status ma'lumotlari
        $status = $this->getStatusInfo($user->is_active);

        // Yoshni hisoblash
        $age = null;
        $birthDate = $profile?->birth_date;
        if ($birthDate) {
            $age = Carbon::parse($birthDate)->age;
        }

        // Email
        $email = $user->email ?? $user->login . '@hospital.uz';

        // ID raqami
        $userId = 'NRS-' . str_pad($user->id, 5, '0', STR_PAD_LEFT);

        // Sana formatlari
        $createdAt = Carbon::parse($user->created_at);
        $updatedAt = Carbon::parse($user->updated_at);
        $hiredDate = $createdAt->format('d.m.Y');
        $createdAtFormatted = $createdAt->format('d.m.Y H:i');
        $updatedAtFormatted = $updatedAt->format('d.m.Y H:i');
        $birthDateFormatted = $birthDate ? Carbon::parse($birthDate)->format('d.m.Y') : null;

        // Faoliyat tarixi
        $timeline = $this->getTimeline($user, $createdAt, $updatedAt);

        // Qo'shimcha ma'lumot
        $description = $user->description ?? 'Qo\'shimcha ma\'lumotlar mavjud emas.';

        return [
            // User ma'lumotlari
            'user' => $user,
            'profile' => $profile,
            
            // Avatar
            'avatarLetters' => $avatarLetters,
            
            // Status
            'status' => $status,
            
            // Shaxsiy ma'lumotlar
            'fullName' => $user->name . ' ' . $user->last_name,
            'login' => $user->login,
            'phone' => $user->phone,
            'birthDate' => $birthDate,
            'birthDateFormatted' => $birthDateFormatted,
            'age' => $age,
            
            // Kasbiy ma'lumotlar
            'specialization' => $profile?->specialization ?? 'Mavjud emas',
            'experienceYears' => $profile?->experience_years ?? 0,
            'hiredDate' => $hiredDate,
            
            // Aloqa
            'address' => $profile?->address ?? 'Mavjud emas',
            'email' => $email,
            
            // Sistema
            'userId' => $userId,
            'createdAtFormatted' => $createdAtFormatted,
            'updatedAtFormatted' => $updatedAtFormatted,
            
            // Qo'shimcha
            'description' => $description,
            
            // Timeline
            'timeline' => $timeline,
        ];
    }

    /**
     * Status ma'lumotlarini olish
     */
    private function getStatusInfo($status)
    {
        $statusMap = [
            '1' => [
                'label' => 'Faol',
                'color' => 'rgba(46, 204, 113, 0.15)',
                'textColor' => '#27ae60',
                'borderColor' => 'rgba(46, 204, 113, 0.3)',
                'icon' => 'fas fa-circle-check'
            ],
            'active' => [
                'label' => 'Faol',
                'color' => 'rgba(46, 204, 113, 0.15)',
                'textColor' => '#27ae60',
                'borderColor' => 'rgba(46, 204, 113, 0.3)',
                'icon' => 'fas fa-circle-check'
            ],
            'inactive' => [
                'label' => 'Nofaol',
                'color' => 'rgba(231, 76, 60, 0.15)',
                'textColor' => '#dc3545',
                'borderColor' => 'rgba(231, 76, 60, 0.3)',
                'icon' => 'fas fa-circle-xmark'
            ],
            'on_leave' => [
                'label' => "Ta'tilda",
                'color' => 'rgba(243, 156, 18, 0.15)',
                'textColor' => '#f39c12',
                'borderColor' => 'rgba(243, 156, 18, 0.3)',
                'icon' => 'fas fa-umbrella-beach'
            ]
        ];

        return $statusMap[$status] ?? $statusMap['inactive'];
    }

    /**
     * Faoliyat tarixini tayyorlash
     */
    private function getTimeline($user, $createdAt, $updatedAt)
    {
        $timeline = [];

        // 1. Sistemaga qo'shilgan
        $timeline[] = [
            'icon' => 'fas fa-user-plus',
            'title' => 'Sistemaga qo\'shilgan',
            'date' => $createdAt->format('d.m.Y H:i'),
            'description' => 'Hamshira ro\'yxatiga qo\'shildi'
        ];

        // 2. Ishga kirgan
        $timeline[] = [
            'icon' => 'fas fa-calendar-check',
            'title' => 'Ishga kirgan sana',
            'date' => $createdAt->format('d.m.Y'),
            'description' => 'Kasbiy faoliyatini boshlagan'
        ];

        // 3. Status o'zgargan bo'lsa
        if ($user->status_changed_at) {
            $statusLabel = '';
            if ($user->status == 'active') {
                $statusLabel = 'Faol holatga o\'tkazilgan';
            } elseif ($user->status == 'inactive') {
                $statusLabel = 'Nofaol holatga o\'tkazilgan';
            } elseif ($user->status == 'on_leave') {
                $statusLabel = 'Ta\'til holatiga o\'tkazilgan';
            }

            $timeline[] = [
                'icon' => 'fas fa-sync-alt',
                'title' => 'Holati yangilangan',
                'date' => Carbon::parse($user->status_changed_at)->format('d.m.Y H:i'),
                'description' => $statusLabel
            ];
        }

        // 4. Oxirgi yangilangan
        $timeline[] = [
            'icon' => 'fas fa-edit',
            'title' => 'Oxirgi yangilangan',
            'date' => $updatedAt->format('d.m.Y H:i'),
            'description' => 'Ma\'lumotlar oxirgi marta yangilangan'
        ];

        return $timeline;
    }

    public function getSingleAppointment(Appointment $appointment)
    {   
        // Appointment bilan bog'liq ma'lumotlarni yuklash
        $appointment->load(['doctor.user', 'doctor.departments', 'appointmentSlot']);
        
        $doctorInfo = $this->getDoctorInfo($appointment->doctor);
        $departmentInfo = $this->getDepartmentInfo($appointment->doctor->departments->first());
        $statusAppointment = $this->getStatusAppointmnet($appointment->status);
        $patientInfo = $this->getPatientInfo($appointment->patient);

        // Prescriptions - Retseptlar
        $prescriptions = $this->getPrescriptions($appointment);
        
        return [
            'id' => $appointment->id,
            'patient_id' => $appointment->patient_id,
            'doctor_id' => $appointment->doctor_id,
            'appointment_slot_id' => $appointment->appointment_slot_id,
            
            // Doctor
            'doctorId' => $doctorInfo['id'],
            'doctorName' => $doctorInfo['name'],
            'doctorFullName' => $doctorInfo['name'] . ' ' . $doctorInfo['lastName'],
            'doctorSpecialization' => $doctorInfo['specialization'],
            'doctorPhoto' => $doctorInfo['image'],
            'doctorExperienceYears' => $doctorInfo['experience_years'],
            'doctorStatus' => $doctorInfo['status'] ?? 'active',
            'doctorRole' => $doctorInfo['role'] ?? 'doctor',
            
            // Department
            'departmentId' => $departmentInfo['id'],
            'departmentName' => $departmentInfo['name'], 

            // Patient
            'patient_name' => $patientInfo['last_name'] . ' ' . $patientInfo['name'],
            'patient_last_name' => $patientInfo['last_name'],
            'patient_birthdate' => $patientInfo['birth_date'],
            'patient_phone' => $patientInfo['phone'],
            'patient_gender' => $patientInfo['gender'],

            // Complaints
            'appointment_reason' => $appointment->reason,
            'appointment_notes' => $appointment->notes,
            
            // Appointment Slot
            'appointmentDate' => Carbon::parse($appointment->appointmentSlot->date)->format('D, d M'),
            'appointmentTime' => Carbon::parse($appointment->appointmentSlot->start_time)->format('H:i'),
            
            // Status
            'status' => $appointment->status,
            'status_text' => $statusAppointment['text'],
            'status_text_color' => $statusAppointment['text_color'],
            'status_bg_color' => $statusAppointment['bg_color'],
            'status_icon' => $statusAppointment['icon'],
            
            // Diagnosis
            'diagnosis' =>  $appointment->diagnosis->diagnosis ?? 'Tashxis qo\'yilmagan',
            'full_diagnosis' =>  $appointment->diagnosis->full_diagnosis ?? 'Tashxis qo\'yilmagan',
            'recommendations' =>  $appointment->diagnosis->recommendations ?? 'Tashxis qo\'yilmagan',
            'has_diagnosis' => !is_null($appointment->diagnosis),

            // Prescriptions - Retseptlar
            'prescriptions' => $prescriptions,
            'has_prescriptions' => !empty($prescriptions),
        ];
    }
 

    public function getPrescriptions($appointment)
    {
        $prescriptions = Prescription::where('appointment_id', $appointment->id)
            ->orderBy('prescription_date', 'desc')
            ->get();
        
        $result = [];
        
        foreach ($prescriptions as $prescription) {
            $items = PrescriptionItem::where('prescription_id', $prescription->id)
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'medicine_id' => $item->medicine_id,
                        'medicine' => $item->medicine->name . ' ' . $item->medicine->strength_value . ' ' . $item->medicine->strength_unit,
                        'frequency_type' => $item->frequency_type,
                        'frequency_value' => $item->frequency_value,
                        'dose_amount' => $item->dose_amount,
                        'duration_days' => $item->duration_days,
                        'usage_instructions' => $item->usage_instructions,
                        'note' => $item->note,
                        'formatted_text' => $this->formatPrescriptionText([
                            'dose_amount' => $item->dose_amount,
                            'frequency_type' => $item->frequency_type,
                            'frequency_value' => $item->frequency_value,
                            'duration_days' => $item->duration_days,
                        ])
                    ];
                });
            
            $result[] = [
                'id' => $prescription->id,
                'doctor_id' => $prescription->doctor_id,
                'patient_id' => $prescription->patient_id,
                'appointment_id' => $prescription->appointment_id,
                'prescription_date' => $prescription->prescription_date,
                'status' => $prescription->status,
                'items' => $items
            ];
        }
        
        return $result;
    }

    public static function formatPrescriptionText($item)
    {
        $doseAmount = $item['dose_amount'] ?? '';
        $frequencyType = $item['frequency_type'] ?? '';
        $frequencyValue = $item['frequency_value'] ?? 0;
        $durationDays = $item['duration_days'] ?? null;
        
        $text = '';
        
        switch ($frequencyType) {
            case 'daily':
                $text = "Kuniga {$frequencyValue} ta tabletka";
                if ($durationDays) {
                    $text .= " - {$durationDays} kun";
                }
                break;
                
            case 'hourly':
                $text = "Har {$frequencyValue} soat";
                if ($doseAmount) {
                    $text .= " | {$doseAmount} ta tabletka";
                }
                if ($durationDays) {
                    $text .= " - {$durationDays} kun";
                }
                break;
                
            case 'weekly':
                $text = "Haftasiga {$frequencyValue} marta";
                if ($doseAmount) {
                    $text .= " | {$doseAmount} tabletkadan";
                }
                if ($durationDays) {
                    $text .= " - {$durationDays} kun";
                }
                break;
                
            case 'as_needed':
                $text = "zaruratga qarab";
                if ($doseAmount) {
                    $text .= " {$doseAmount} ta tabletka dan";
                }
                break;
                
            case 'once':
                $text = "Bir marta";
                if ($doseAmount) {
                    $text .= " {$doseAmount} ta tabletka";
                }
                break;
                
            default:
                $text = $doseAmount;
                if ($durationDays) {
                    $text .= " - {$durationDays} kun";
                }
                break;
        }
        
        return $text;
    }


    public function patientAppointments()
    {
        $user = auth()->user();
        $patient = Patient::where('user_id', $user->id)->first();
        
        if (!$patient) {
            return redirect()->back()->with('error', 'Patient not found');
        }
        
        $appointments = Appointment::where('patient_id', $patient->id)
        ->with(['doctor.user', 'doctor.departments', 'appointmentSlot'])
        ->orderByDesc('created_at')
        ->paginate(10);
    
        $appointments->setCollection(
            collect($this->getAppointmentList($appointments))
        );
        
        return $appointments;
    }

    public function getAppointmentList($appointments)
    {
        $result = [];

        foreach($appointments as $appointment){

            $appointmentInfo = $this->getappointmentInfo($appointment); 
            $doctorInfo = $this->getDoctorInfo($appointment->doctor);
            $departmentInfo = $this->getDepartmentInfo($appointment->doctor->departments->first()); 
            $statusAppointmnet = $this->getStatusAppointmnet($appointment->status);

            $result[] = [
                'appointmentId' => $appointmentInfo['id'],
                'patient_id' => $appointmentInfo['patient_id'],
                'doctor_id' => $appointmentInfo['doctor_id'],
                'appointment_slot_id' => $appointmentInfo['appointment_slot_id'],
    
                // Doctor
                'doctorId' => $doctorInfo['id'], 
                'doctorName' => $doctorInfo['name'],
                'doctorFullName' => $doctorInfo['name'] . ' ' . $doctorInfo['lastName'],
                'doctorSpecialization' => $doctorInfo['specialization'],
                'doctorPhoto' => $doctorInfo['image'],
                'doctorExperienceYears' => $doctorInfo['experience_years'],
                'doctorStatus' => $doctorInfo['status'] ?? 'active',
                'doctorRole' => $doctorInfo['role'] ?? 'doctor',
    
                // Department ma'lumotlari
                'departmentId' => $departmentInfo['id'],
                'departmentName' => $departmentInfo['name'],
    
                // Appointment Slot ma'lumotlari
                'appointmentDate' => Carbon::parse($appointment->appointmentSlot->date)->format('D, d M'),
    
                // Status ma'lumotlari 
                'status' => $appointment->status,
                'status_text' => $statusAppointmnet['text'],
                'status_text_color' => $statusAppointmnet['text_color'],
                'status_bg_color' => $statusAppointmnet['bg_color'],
                'status_icon' => $statusAppointmnet['icon'],
                
                // Diagnosis
                'diagnosis' => $appointment->diagnosis ?? null,
                'has_diagnosis' => !is_null($appointment->diagnosis) ?? null, 
            ];


        }

        return $result;
    }

    private function getAppointmentInfo(Appointment $appointment): array
    {
        return [
            'id' => $appointment->id,
            'patient_id' => $appointment->patient_id,
            'doctor_id' => $appointment->doctor_id,
            'appointment_slot_id' => optional($appointment->appointmentSlot)->id,
        ];
    }

    private function getDoctorInfo(Doctor $doctor): array
    {
        return [
            'id' => $doctor->id,
            'name' => $doctor->user->name,
            'lastName' => $doctor->user->last_name,
            'middleName' => $doctor->user->middle_name,
            'specialization' => $doctor->specialization,
            'image' => asset('storage/' . $doctor->photo),
            'experience_years' => $doctor->experience_years,
            'status' => $doctor->status ?? 'active',
            'role' => $doctor->role ?? 'doctor',
        ];
    }

    private function getDepartmentInfo(?Department $department): array
    {
        if (!$department) {
            return [
                'id' => null,
                'name' => null,
            ];
        }
    
        return [
            'id' => $department->id,
            'name' => $department->name,
        ];
    }

    private function getStatusAppointmnet(string $status): array
    {
        return match($status) {
            'completed' => [
                'text' => __('words.completed'),
                'text_color' => '#27ae60',
                'bg_color' => '#e8f8f5',
                'icon' => 'fas fa-check'
            ],
            'booked' => [
                'text' => __('words.pending'),
                'text_color' => '#f39c12',
                'bg_color' => '#fef9e7',
                'icon' => 'fas fa-umbrella-beach'
            ],
            'cancelled' => [
                'text' => __('words.cancelled'),
                'text_color' => '#e74c3c',
                'bg_color' => '#fdedec',
                'icon' => 'fas fa-circle-xmark'
            ],
            default => [
                'text' => __('words.unknown'),
                'text_color' => '#95a5a6',
                'bg_color' => '#f5f5f5',
                'icon' => 'fas fa-question-circle'
            ],
        };
    }

    private function getPatientInfo($patient)
    {
        return [
            'name' => $patient->user->name, 
            'last_name' => $patient->user->last_name, 
            'birth_date' => Carbon::parse($patient->birth_date)->format('d.m.Y'),
            'phone' => $patient->user->phone,
            'gender' => $patient->user->gender,
        ];
    }
 
}