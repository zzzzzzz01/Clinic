<?php

namespace Database\Seeders;

use App\Models\Hospitalization;
use App\Models\HospitalizationProcedure;
use App\Models\HospitalizationProcedureAdministration;
use App\Models\HospitalizationStaff;
use App\Models\HospitalizationRoom;
use App\Models\Procedure;
use App\Models\Doctor;
use App\Models\Nurse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HistoricalHospitalizationProcedureSeeder extends Seeder
{
    public function run(): void
    {
        // ========== STATUSI DISCHARGED BO'LGAN HOSPITALIZATIONS ==========
        $hospitalizations = Hospitalization::where('status', 'discharged')->get();

        if ($hospitalizations->isEmpty()) {
            $this->command->info('Hech qanday discharged hospitalization topilmadi!');
            return;
        }

        $procedures = Procedure::all();

        if ($procedures->isEmpty()) {
            $this->command->info('Hech qanday procedure topilmadi!');
            return;
        }

        foreach ($hospitalizations as $hospitalization) {
            // ========== 1. DOCTOR STAFF ==========
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

            // ========== 2. NURSE STAFFS ==========
            $nurseStaffs = HospitalizationStaff::where('hospitalization_id', $hospitalization->id)
                ->where('staff_type', 'App\Models\Nurse')
                ->get();

            if ($nurseStaffs->isEmpty()) {
                continue;
            }

            // ========== 3. ROOM - HOSPITALIZATION_ROOMS JADVALIDAN OHIRGISINI OLAMIZ ==========
            $hospitalizationRoom = HospitalizationRoom::where('hospitalization_id', $hospitalization->id)
                ->orderBy('id', 'desc')
                ->first();

            $roomId = null;
            if ($hospitalizationRoom) {
                // Bed orqali Room ni olamiz
                $bed = $hospitalizationRoom->bed;
                if ($bed) {
                    $room = $bed->room;
                    if ($room) {
                        $roomId = $room->id;
                    }
                }
            }

            // Agar room topilmasa, hospitalization->room_id dan olamiz
            if (!$roomId) {
                $roomId = $hospitalization->room_id;
            }

            $patientId = $hospitalization->appointment->patient_id;
            $admittedAt = Carbon::parse($hospitalization->admitted_at);
            $dischargedAt = Carbon::parse($hospitalization->discharged_at);

            // ========== 4. HAR BIR HOSPITALIZATION UCHUN 2-4 TA PROCEDURE ==========
            $procedureCount = rand(2, 4);
            $randomProcedures = $procedures->random(min($procedureCount, $procedures->count()));

            foreach ($randomProcedures as $procedure) {
                // ========== 5. PROCEDURE VAQTI ==========
                $assignedAt = $admittedAt->copy()->addDays(rand(0, 5))->addHours(rand(8, 18))->addMinutes(rand(0, 59));
                
                if ($assignedAt > $dischargedAt) {
                    $assignedAt = $dischargedAt->copy()->subDays(rand(1, 3))->setTime(10, 0, 0);
                }

                // ========== 6. PROCEDURE YARATISH (status = completed) ==========
                $procedureRecord = HospitalizationProcedure::create([
                    'hospitalization_id' => $hospitalization->id,
                    'patient_id' => $patientId,
                    'procedure_id' => $procedure->id,
                    'staff_id' => $doctor->id,
                    'staff_type' => 'App\Models\Doctor',
                    'price' => $procedure->price,
                    'assigned_at' => $assignedAt,
                    'room_id' => $roomId,
                    'status' => 'completed',
                ]);

                // ========== 7. ADMINISTRATION ==========
                $administeredAt = $assignedAt->copy()->addHours(rand(1, 4))->addMinutes(rand(0, 59));
                
                if ($administeredAt > $dischargedAt) {
                    $administeredAt = $dischargedAt->copy()->subHours(rand(1, 5));
                }

                $nurseStaff = $nurseStaffs->random();
                $nurse = Nurse::find($nurseStaff->staff_id);

                if ($nurse) {
                    HospitalizationProcedureAdministration::create([
                        'hospitalization_id' => $hospitalization->id,
                        'hospitalization_procedure_id' => $procedureRecord->id,
                        'patient_id' => $patientId,
                        'administered_by_type' => 'App\Models\Nurse',
                        'administered_by_id' => $nurse->id,
                        'administration_at' => $administeredAt,
                    ]);
                }
            }
        }

        $this->command->info('✅ All discharged hospitalizations procedures processed successfully!');
    }
}