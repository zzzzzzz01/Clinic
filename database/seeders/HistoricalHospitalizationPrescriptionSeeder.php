<?php

namespace Database\Seeders;

use App\Models\Hospitalization;
use App\Models\HospitalizationPrescription;
use App\Models\HospitalizationPrescriptionItem;
use App\Models\HospitalizationPrescriptionItemSlot;
use App\Models\HospitalizationPrescriptionAdministration;
use App\Models\HospitalizationStaff;
use App\Models\Medicine;
use App\Models\Doctor;
use App\Models\Nurse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HistoricalHospitalizationPrescriptionSeeder extends Seeder
{
    public function run(): void
    {
        $hospitalizations = Hospitalization::whereBetween('id', [1, 150])->get();

        $medicines = Medicine::all();

        $frequencyTypes = ['daily', 'weekly', 'hourly', 'once', 'as_needed'];
        $reasons = ['standard', 'emergency', 'verbal'];

        foreach ($hospitalizations as $hospitalization) {
            $doctorStaff = HospitalizationStaff::where('hospitalization_id', $hospitalization->id)
                ->where('staff_type', 'App\Models\Doctor')
                ->first();

            if (!$doctorStaff) {
                continue;
            }

            $doctor = Doctor::find($doctorStaff->staff_id);
            if (!$doctor) {
                continue;
            }

            $nurseStaffs = HospitalizationStaff::where('hospitalization_id', $hospitalization->id)
                ->where('staff_type', 'App\Models\Nurse')
                ->get();

            if ($nurseStaffs->isEmpty()) {
                continue;
            }

            $patientId = $hospitalization->appointment->patient_id;
            $admittedAt = Carbon::parse($hospitalization->admitted_at);
            $dischargedAt = Carbon::parse($hospitalization->discharged_at);

            // Har bir hospitalizations uchun 2-3 ta prescription
            $prescriptionCount = rand(2, 3);

            for ($p = 0; $p < $prescriptionCount; $p++) {
                $prescribedAt = $admittedAt->copy()->addDays(rand(1, 5))->addHours(rand(8, 18))->addMinutes(rand(0, 59));

                // ========== 1. PRESCRIPTION YARATISH (status ACTIVE) ==========
                $prescription = HospitalizationPrescription::create([
                    'hospitalization_id' => $hospitalization->id,
                    'patient_id' => $patientId,
                    'prescribed_by_id' => $doctor->id,
                    'prescribed_by_type' => 'doctor',
                    'prescribed_at' => $prescribedAt,
                    'reason' => $reasons[array_rand($reasons)],
                    'note' => rand(0, 1) ? 'Bemor ahvoliga qarab buyurildi' : null,
                    'status' => 'active',
                    'stopped_at' => null,
                ]);

                // ========== 2. Bitta dori tanlaymiz ==========
                $medicine = $medicines->random();
                
                $frequencyType = $frequencyTypes[array_rand($frequencyTypes)];
                
                // Aniq frequency qiymatlari
                $frequencyValue = match($frequencyType) {
                    'daily' => rand(1, 3),
                    'weekly' => rand(1, 2),
                    'hourly' => rand(2, 6),
                    'once' => 1,
                    'as_needed' => rand(1, 3),
                    default => 1,
                };

                $doseAmount = round(rand(1, 10) / 2, 1);
                
                // Duration Days - weekly uchun 7 ga bo'linadigan son
                $durationDays = match($frequencyType) {
                    'weekly' => rand(1, 4) * 7, // 7, 14, 21, 28
                    default => rand(3, 10),
                };
                
                $startAt = $prescribedAt->copy()->addDays(rand(0, 2))->setTime(8, 0, 0);
                $endAt = $startAt->copy()->addDays($durationDays);

                // ========== 3. PRESCRIPTION ITEM (status COMPLETED) ==========
                $item = HospitalizationPrescriptionItem::create([
                    'hospitalization_prescription_id' => $prescription->id,
                    'medicine_id' => $medicine->id,
                    'frequency_type' => $frequencyType,
                    'frequency_value' => $frequencyValue,
                    'dose_amount' => $doseAmount,
                    'duration_days' => $durationDays,
                    'start_at' => $startAt,
                    'end_at' => $endAt,
                    'status' => 'completed', // ✅ COMPLETED
                    'stopped_at' => null,
                ]);

                // ========== 4. SLOTLARNI YARATISH ==========
                
                // SlotCount ni to'g'ri hisoblash
                $slotCount = match($frequencyType) {
                    'daily' => $durationDays * $frequencyValue,
                    'weekly' => (int)($durationDays / 7) * $frequencyValue,
                    'hourly' => (int)ceil($durationDays * (24 / $frequencyValue)),
                    'once' => 1,
                    'as_needed' => rand(2, 5),
                    default => $durationDays,
                };

                // Butun songa aylantirish va kamida 1 ta bo'lishini ta'minlash
                $slotCount = max(1, (int)$slotCount);

                $slotOrder = 1;
                $currentSlotTime = $startAt->copy();

                // ========== 5. SLOTLARNI YARATISH ==========
                for ($s = 0; $s < $slotCount; $s++) {
                    // Agar currentSlotTime end_at dan o'tib ketsa, to'xtatamiz
                    if ($currentSlotTime > $endAt) {
                        break;
                    }

                    // ========== 6. HAR 3-4 SLOTDAN BIRINI SKIPPED QILAMIZ ==========
                    $slotStatus = 'given';
                    
                    // Har 3 yoki 4 slotdan birini skipped qilamiz
                    if ($slotOrder % rand(3, 4) == 0) {
                        $slotStatus = 'skipped';
                    }
                    
                    $adminStatus = $slotStatus;
                    
                    $skipReason = null;
                    if ($slotStatus === 'skipped') {
                        $skipReasons = ['Bemor rad etdi', 'Dori tugab qolgan', 'Bemor yo\'q', 'Shifokor ko\'rsatmasi'];
                        $skipReason = $skipReasons[array_rand($skipReasons)];
                    }

                    $nurse = $nurseStaffs->random();
                    $nurseModel = Nurse::find($nurse->staff_id);
                    
                    $administeredByType = 'Nurse';
                    $administeredById = $nurseModel->id;
                    
                    // Administered at - slot vaqtiga yaqin vaqt
                    $administeredAt = $currentSlotTime->copy()->addHours(rand(0, 2))->addMinutes(rand(0, 59));

                    // Slot yaratish
                    $slot = HospitalizationPrescriptionItemSlot::create([
                        'hospitalization_prescription_item_id' => $item->id,
                        'scheduled_at' => $currentSlotTime,
                        'status' => $slotStatus,
                        'skip_reason' => $skipReason,
                        'slot_order' => $slotOrder,
                    ]);

                    // Administratsiya yaratish
                    HospitalizationPrescriptionAdministration::create([
                        'hospitalization_prescription_item_id' => $item->id,
                        'hospitalization_prescription_item_slot_id' => $slot->id,
                        'administered_by_type' => $administeredByType,
                        'administered_by_id' => $administeredById,
                        'administered_at' => $administeredAt,
                        'status' => $adminStatus,
                        'skip_reason' => $skipReason,
                    ]);

                    // Keyingi slot vaqtini to'g'ri hisoblash
                    $currentSlotTime = match($frequencyType) {
                        'daily' => $currentSlotTime->copy()->addHours(24 / $frequencyValue),
                        'weekly' => $currentSlotTime->copy()->addDays(7),
                        'hourly' => $currentSlotTime->copy()->addHours($frequencyValue),
                        'once' => $currentSlotTime->copy()->addDays(1),
                        'as_needed' => $currentSlotTime->copy()->addHours(rand(4, 12)),
                        default => $currentSlotTime->copy()->addDays(1),
                    };

                    $slotOrder++;
                }
            }
        }
    }
}