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

class HospitalizationPrescriptionSeeder extends Seeder
{
    public function run(): void
    {
        $hospitalizations = Hospitalization::where('status', 'under_treatment')->get();

        if ($hospitalizations->isEmpty()) {
            $this->command->info('Hech qanday under_treatment hospitalization topilmadi!');
            return;
        }

        $medicines = Medicine::all();

        if ($medicines->isEmpty()) {
            $this->command->info('Hech qanday dori topilmadi!');
            return;
        }

        $frequencyTypes = ['daily', 'weekly', 'hourly', 'once', 'as_needed'];
        $reasons = ['standard', 'emergency', 'verbal'];

        // ========== HOZIRGI OY ==========
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

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
            
            if ($admittedAt > $now) {
                $admittedAt = $now->copy()->subDays(rand(1, 3));
            }

            $prescriptionCount = rand(2, 3);

            for ($p = 0; $p < $prescriptionCount; $p++) {
                // ========== HOZIRGI OY ORALIG'IDA PRESCRIBED_AT ==========
                $daysDiff = $startOfMonth->diffInDays($endOfMonth);
                $randomDays = $daysDiff > 0 ? rand(0, $daysDiff) : 0;
                $prescribedAt = $startOfMonth->copy()->addDays($randomDays)->addHours(rand(8, 18))->addMinutes(rand(0, 59));
                
                if ($prescribedAt > $now) {
                    $prescribedAt = $now->copy()->subHours(rand(1, 5));
                }

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

                $medicine = $medicines->random();
                
                $frequencyType = $frequencyTypes[array_rand($frequencyTypes)];
                
                $frequencyValue = match($frequencyType) {
                    'daily' => rand(1, 3),
                    'weekly' => rand(1, 2),
                    'hourly' => rand(2, 6),
                    'once' => 1,
                    'as_needed' => rand(1, 3),
                    default => 1,
                };

                $doseAmount = round(rand(1, 10) / 2, 1);
                
                // ========== DURATION DAYS - KO'PROQ DAVOM ETADIGAN QILAMIZ ==========
                $durationDays = 0;
                
                if ($frequencyType === 'weekly') {
                    $durationDays = rand(2, 4) * 7; // 14, 21, 28 kun
                } elseif ($frequencyType === 'hourly') {
                    $durationDays = rand(3, 7); // 3-7 kun
                } elseif ($frequencyType === 'daily') {
                    $durationDays = rand(5, 10); // 5-10 kun
                } elseif ($frequencyType === 'once') {
                    $durationDays = 1;
                } else { // as_needed
                    $durationDays = rand(3, 7);
                }
                
                // ========== START AT ==========
                $startAt = $prescribedAt->copy()->addDays(rand(0, 1))->setTime(8, 0, 0);
                
                // ========== END AT - HECHAM TUGAMASIN, HOZIRGI VAQTDAN KEYIN BO'LSIN ==========
                // 80% ehtimol bilan end_at hozirgi vaqtdan keyin bo'lsin (active)
                $isActive = rand(1, 100) <= 80;
                
                if ($isActive) {
                    // Active bo'lishi uchun end_at hozirgi vaqtdan keyin
                    $endAt = $now->copy()->addDays(rand(2, 10));
                } else {
                    // Completed bo'lishi uchun end_at hozirgi vaqtdan oldin
                    $endAt = $now->copy()->subDays(rand(1, 3));
                    // Lekin start_at dan keyin bo'lishi kerak
                    if ($endAt < $startAt) {
                        $endAt = $startAt->copy()->addDays(rand(1, 2));
                    }
                }
                
                // End_at start_at dan katta bo'lishi kerak
                if ($endAt <= $startAt) {
                    $endAt = $startAt->copy()->addDays($durationDays);
                }

                $itemStatus = $isActive ? 'active' : 'completed';

                $item = HospitalizationPrescriptionItem::create([
                    'hospitalization_prescription_id' => $prescription->id,
                    'medicine_id' => $medicine->id,
                    'frequency_type' => $frequencyType,
                    'frequency_value' => $frequencyValue,
                    'dose_amount' => $doseAmount,
                    'duration_days' => $durationDays,
                    'start_at' => $startAt,
                    'end_at' => $endAt,
                    'status' => $itemStatus,
                    'stopped_at' => null,
                ]);

                // ========== SLOTLARNI YARATISH ==========
                $slotCount = 0;
                
                if ($frequencyType === 'daily') {
                    $slotCount = $durationDays * $frequencyValue;
                } elseif ($frequencyType === 'weekly') {
                    $slotCount = (int)($durationDays / 7) * $frequencyValue;
                } elseif ($frequencyType === 'hourly') {
                    $slotCount = (int)ceil($durationDays * (24 / $frequencyValue));
                } elseif ($frequencyType === 'once') {
                    $slotCount = 1;
                } else { // as_needed
                    $slotCount = rand(2, 4);
                }
                
                $slotCount = max(1, (int)$slotCount);
                
                if ($slotCount > 30) {
                    $slotCount = rand(5, 15);
                }

                $slotOrder = 1;
                $currentSlotTime = $startAt->copy();

                for ($s = 0; $s < $slotCount; $s++) {
                    if ($currentSlotTime >= $endAt) {
                        break;
                    }

                    // ========== SLOT STATUSI ==========
                    if ($itemStatus === 'completed') {
                        $slotStatus = 'given';
                        if ($slotOrder % rand(3, 4) == 0) {
                            $slotStatus = 'skipped';
                        }
                    } else {
                        // Active item - hozirgi vaqtdan oldingi slotlar given, keyingilari pending
                        if ($currentSlotTime <= $now) {
                            $slotStatus = 'given';
                            if ($slotOrder % rand(3, 4) == 0) {
                                $slotStatus = 'skipped';
                            }
                        } else {
                            $slotStatus = 'pending';
                        }
                    }
                    
                    $skipReason = null;
                    $administeredAt = null;
                    $adminStatus = $slotStatus;
                    
                    if ($slotStatus === 'skipped') {
                        $skipReasons = ['Bemor rad etdi', 'Dori tugab qolgan', 'Bemor yo\'q', 'Shifokor ko\'rsatmasi'];
                        $skipReason = $skipReasons[array_rand($skipReasons)];
                        $administeredAt = $currentSlotTime->copy()->addHours(rand(0, 1))->addMinutes(rand(0, 59));
                        if ($administeredAt > $now) {
                            $administeredAt = $now->copy()->subMinutes(rand(1, 30));
                        }
                    } elseif ($slotStatus === 'given') {
                        $administeredAt = $currentSlotTime->copy()->addHours(rand(0, 1))->addMinutes(rand(0, 59));
                        if ($administeredAt > $now) {
                            $administeredAt = $now->copy()->subMinutes(rand(1, 30));
                        }
                    }

                    $nurse = $nurseStaffs->random();
                    $nurseModel = Nurse::find($nurse->staff_id);
                    
                    $administeredByType = 'Nurse';
                    $administeredById = $nurseModel->id;

                    $slot = HospitalizationPrescriptionItemSlot::create([
                        'hospitalization_prescription_item_id' => $item->id,
                        'scheduled_at' => $currentSlotTime,
                        'status' => $slotStatus,
                        'skip_reason' => $skipReason,
                        'slot_order' => $slotOrder,
                    ]);

                    if ($slotStatus !== 'pending') {
                        HospitalizationPrescriptionAdministration::create([
                            'hospitalization_prescription_item_id' => $item->id,
                            'hospitalization_prescription_item_slot_id' => $slot->id,
                            'administered_by_type' => $administeredByType,
                            'administered_by_id' => $administeredById,
                            'administered_at' => $administeredAt,
                            'status' => $adminStatus,
                            'skip_reason' => $skipReason,
                        ]);
                    }

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

        $this->command->info('✅ All under_treatment hospitalizations prescriptions processed successfully!');
    }
}