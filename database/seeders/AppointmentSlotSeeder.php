<?php

namespace Database\Seeders;

use App\Models\AppointmentSlot;
use App\Models\StaffSchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AppointmentSlotSeeder extends Seeder
{
    public function run(): void
    {
        // 1. AVVAL HAMMA SLOTLARNI AVAILABLE QILAMIZ (1 OY)
        $this->createAllAvailableSlots();

        // 2. KEYIN HAR BIR DOCTOR UCHUN 3 TA PATIENT BILAN SLOTLARNI BOOKED QILAMIZ (1 OY)
        $this->updateSlotsToBooked();
    }

    private function createAllAvailableSlots()
    {
        // 1 oy uchun (hozirgi oyning 1-kunidan oy oxirigacha)
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        
        $schedules = StaffSchedule::where('schedulable_type', 'App\Models\Doctor')
            ->where('is_working', 1)
            ->get();

        foreach ($schedules as $schedule) {
            $currentDate = $startDate->copy();
            
            while ($currentDate <= $endDate) {
                $dayOfWeek = $currentDate->dayOfWeek;
                
                if ($schedule->day_id == $dayOfWeek) {
                    $this->createAvailableSlotsForDay($schedule, $currentDate);
                }
                
                $currentDate->addDay();
            }
        }
    }

    private function createAvailableSlotsForDay($schedule, $date)
    {
        $startTime = Carbon::parse($schedule->start_time);
        $endTime = Carbon::parse($schedule->end_time);
        $lunchStart = Carbon::parse($schedule->lunch_start);
        $lunchEnd = Carbon::parse($schedule->lunch_end);
        $duration = $schedule->appointment_duration;

        while ($startTime < $endTime) {
            if ($startTime >= $lunchStart && $startTime < $lunchEnd) {
                $startTime = $lunchEnd->copy();
                continue;
            }

            $slotEnd = $startTime->copy()->addMinutes($duration);
            if ($slotEnd > $endTime) break;

            AppointmentSlot::create([
                'staff_schedule_id' => $schedule->id,
                'date' => $date->toDateString(),
                'start_time' => $startTime->format('H:i:s'),
                'end_time' => $slotEnd->format('H:i:s'),
                'status' => 'available',
                'patient_id' => null,
            ]);

            $startTime->addMinutes($duration);
        }
    }

    private function updateSlotsToBooked()
    {
        // ============================================================
        // DOCTOR 1 (Schedule: a) - Patient: 100,101,102
        // ============================================================
        $this->updateBookedSlot(1, 1, '09:30:00', '10:00:00', 100);
        $this->updateBookedSlot(1, 3, '09:00:00', '09:30:00', 100);
        $this->updateBookedSlot(1, 5, '11:00:00', '11:30:00', 100);
        $this->updateBookedSlot(1, 1, '11:00:00', '11:30:00', 101);
        $this->updateBookedSlot(1, 2, '10:00:00', '10:30:00', 101);
        $this->updateBookedSlot(1, 4, '10:30:00', '11:00:00', 101);
        $this->updateBookedSlot(1, 2, '14:30:00', '15:00:00', 102);
        $this->updateBookedSlot(1, 3, '13:30:00', '14:00:00', 102);
        $this->updateBookedSlot(1, 5, '14:00:00', '14:30:00', 102);

        // ============================================================
        // DOCTOR 2 (Schedule: b) - Patient: 103,104,105
        // ============================================================
        $this->updateBookedSlot(2, 1, '13:30:00', '14:00:00', 103);
        $this->updateBookedSlot(2, 3, '14:30:00', '15:00:00', 103);
        $this->updateBookedSlot(2, 5, '15:30:00', '16:00:00', 103);
        $this->updateBookedSlot(2, 1, '15:00:00', '15:30:00', 104);
        $this->updateBookedSlot(2, 2, '14:00:00', '14:30:00', 104);
        $this->updateBookedSlot(2, 4, '13:30:00', '14:00:00', 104);
        $this->updateBookedSlot(2, 2, '16:00:00', '16:30:00', 105);
        $this->updateBookedSlot(2, 3, '15:30:00', '16:00:00', 105);
        $this->updateBookedSlot(2, 5, '17:00:00', '17:30:00', 105);

        // ============================================================
        // DOCTOR 3 (Schedule: c) - Patient: 106,107,108
        // ============================================================
        $this->updateBookedSlot(3, 1, '07:30:00', '08:00:00', 106);
        $this->updateBookedSlot(3, 3, '08:00:00', '08:30:00', 106);
        $this->updateBookedSlot(3, 5, '07:30:00', '08:00:00', 106);
        $this->updateBookedSlot(3, 1, '09:00:00', '09:30:00', 107);
        $this->updateBookedSlot(3, 2, '08:30:00', '09:00:00', 107);
        $this->updateBookedSlot(3, 4, '09:00:00', '09:30:00', 107);
        $this->updateBookedSlot(3, 2, '10:00:00', '10:30:00', 108);
        $this->updateBookedSlot(3, 3, '09:30:00', '10:00:00', 108);
        $this->updateBookedSlot(3, 5, '10:00:00', '10:30:00', 108);

        // ============================================================
        // DOCTOR 4 (Schedule: d) - Patient: 109,110,111
        // ============================================================
        $this->updateBookedSlot(4, 1, '09:30:00', '10:00:00', 109);
        $this->updateBookedSlot(4, 3, '10:00:00', '10:30:00', 109);
        $this->updateBookedSlot(4, 5, '09:30:00', '10:00:00', 109);
        $this->updateBookedSlot(4, 1, '11:00:00', '11:30:00', 110);
        $this->updateBookedSlot(4, 3, '13:30:00', '14:00:00', 110);
        $this->updateBookedSlot(4, 5, '14:00:00', '14:30:00', 110);
        $this->updateBookedSlot(4, 1, '14:30:00', '15:00:00', 111);
        $this->updateBookedSlot(4, 3, '15:30:00', '16:00:00', 111);
        $this->updateBookedSlot(4, 5, '15:30:00', '16:00:00', 111);

        // ============================================================
        // DOCTOR 5 (Schedule: e) - Patient: 112,113,114
        // ============================================================
        $this->updateBookedSlot(5, 2, '09:30:00', '10:00:00', 112);
        $this->updateBookedSlot(5, 4, '10:00:00', '10:30:00', 112);
        $this->updateBookedSlot(5, 6, '09:30:00', '10:00:00', 112);
        $this->updateBookedSlot(5, 2, '11:00:00', '11:30:00', 113);
        $this->updateBookedSlot(5, 4, '13:30:00', '14:00:00', 113);
        $this->updateBookedSlot(5, 6, '14:00:00', '14:30:00', 113);
        $this->updateBookedSlot(5, 2, '14:30:00', '15:00:00', 114);
        $this->updateBookedSlot(5, 4, '15:30:00', '16:00:00', 114);
        $this->updateBookedSlot(5, 6, '15:30:00', '16:00:00', 114);

        // ============================================================
        // DOCTOR 6 (Schedule: f) - Patient: 115,116,117
        // ============================================================
        $this->updateBookedSlot(6, 1, '13:30:00', '14:00:00', 115);
        $this->updateBookedSlot(6, 3, '14:30:00', '15:00:00', 115);
        $this->updateBookedSlot(6, 5, '13:30:00', '14:00:00', 115);
        $this->updateBookedSlot(6, 1, '15:00:00', '15:30:00', 116);
        $this->updateBookedSlot(6, 3, '16:00:00', '16:30:00', 116);
        $this->updateBookedSlot(6, 5, '15:30:00', '16:00:00', 116);
        $this->updateBookedSlot(6, 1, '16:30:00', '17:00:00', 117);
        $this->updateBookedSlot(6, 3, '17:30:00', '18:00:00', 117);
        $this->updateBookedSlot(6, 5, '17:00:00', '17:30:00', 117);

        // ============================================================
        // DOCTOR 7 (Schedule: g) - Patient: 118,119,120
        // ============================================================
        $this->updateBookedSlot(7, 2, '07:30:00', '08:00:00', 118);
        $this->updateBookedSlot(7, 4, '08:00:00', '08:30:00', 118);
        $this->updateBookedSlot(7, 6, '07:30:00', '08:00:00', 118);
        $this->updateBookedSlot(7, 2, '09:00:00', '09:30:00', 119);
        $this->updateBookedSlot(7, 4, '09:30:00', '10:00:00', 119);
        $this->updateBookedSlot(7, 6, '09:00:00', '09:30:00', 119);
        $this->updateBookedSlot(7, 2, '10:30:00', '11:00:00', 120);
        $this->updateBookedSlot(7, 4, '10:30:00', '11:00:00', 120);
        $this->updateBookedSlot(7, 6, '10:30:00', '11:00:00', 120);

        // ============================================================
        // DOCTOR 8 (Schedule: a) - Patient: 121,122,123
        // ============================================================
        $this->updateBookedSlot(8, 1, '09:30:00', '10:00:00', 121);
        $this->updateBookedSlot(8, 3, '09:00:00', '09:30:00', 121);
        $this->updateBookedSlot(8, 5, '11:00:00', '11:30:00', 121);
        $this->updateBookedSlot(8, 1, '11:00:00', '11:30:00', 122);
        $this->updateBookedSlot(8, 2, '10:00:00', '10:30:00', 122);
        $this->updateBookedSlot(8, 4, '10:30:00', '11:00:00', 122);
        $this->updateBookedSlot(8, 2, '14:30:00', '15:00:00', 123);
        $this->updateBookedSlot(8, 3, '13:30:00', '14:00:00', 123);
        $this->updateBookedSlot(8, 5, '14:00:00', '14:30:00', 123);

        // ============================================================
        // DOCTOR 9 (Schedule: b) - Patient: 124,125,126
        // ============================================================
        $this->updateBookedSlot(9, 1, '13:30:00', '14:00:00', 124);
        $this->updateBookedSlot(9, 3, '14:30:00', '15:00:00', 124);
        $this->updateBookedSlot(9, 5, '15:30:00', '16:00:00', 124);
        $this->updateBookedSlot(9, 1, '15:00:00', '15:30:00', 125);
        $this->updateBookedSlot(9, 2, '14:00:00', '14:30:00', 125);
        $this->updateBookedSlot(9, 4, '13:30:00', '14:00:00', 125);
        $this->updateBookedSlot(9, 2, '16:00:00', '16:30:00', 126);
        $this->updateBookedSlot(9, 3, '15:30:00', '16:00:00', 126);
        $this->updateBookedSlot(9, 5, '17:00:00', '17:30:00', 126);

        // ============================================================
        // DOCTOR 10 (Schedule: c) - Patient: 127,128,129
        // ============================================================
        $this->updateBookedSlot(10, 1, '07:30:00', '08:00:00', 127);
        $this->updateBookedSlot(10, 3, '08:00:00', '08:30:00', 127);
        $this->updateBookedSlot(10, 5, '07:30:00', '08:00:00', 127);
        $this->updateBookedSlot(10, 1, '09:00:00', '09:30:00', 128);
        $this->updateBookedSlot(10, 2, '08:30:00', '09:00:00', 128);
        $this->updateBookedSlot(10, 4, '09:00:00', '09:30:00', 128);
        $this->updateBookedSlot(10, 2, '10:00:00', '10:30:00', 129);
        $this->updateBookedSlot(10, 3, '09:30:00', '10:00:00', 129);
        $this->updateBookedSlot(10, 5, '10:00:00', '10:30:00', 129);

        // ============================================================
        // DOCTOR 11 (Schedule: d) - Patient: 130,131,132
        // ============================================================
        $this->updateBookedSlot(11, 1, '09:30:00', '10:00:00', 130);
        $this->updateBookedSlot(11, 3, '10:00:00', '10:30:00', 130);
        $this->updateBookedSlot(11, 5, '09:30:00', '10:00:00', 130);
        $this->updateBookedSlot(11, 1, '11:00:00', '11:30:00', 131);
        $this->updateBookedSlot(11, 3, '13:30:00', '14:00:00', 131);
        $this->updateBookedSlot(11, 5, '14:00:00', '14:30:00', 131);
        $this->updateBookedSlot(11, 1, '14:30:00', '15:00:00', 132);
        $this->updateBookedSlot(11, 3, '15:30:00', '16:00:00', 132);
        $this->updateBookedSlot(11, 5, '15:30:00', '16:00:00', 132);

        // ============================================================
        // DOCTOR 12 (Schedule: e) - Patient: 133,134,135
        // ============================================================
        $this->updateBookedSlot(12, 2, '09:30:00', '10:00:00', 133);
        $this->updateBookedSlot(12, 4, '10:00:00', '10:30:00', 133);
        $this->updateBookedSlot(12, 6, '09:30:00', '10:00:00', 133);
        $this->updateBookedSlot(12, 2, '11:00:00', '11:30:00', 134);
        $this->updateBookedSlot(12, 4, '13:30:00', '14:00:00', 134);
        $this->updateBookedSlot(12, 6, '14:00:00', '14:30:00', 134);
        $this->updateBookedSlot(12, 2, '14:30:00', '15:00:00', 135);
        $this->updateBookedSlot(12, 4, '15:30:00', '16:00:00', 135);
        $this->updateBookedSlot(12, 6, '15:30:00', '16:00:00', 135);

        // ============================================================
        // DOCTOR 13 (Schedule: f) - Patient: 136,137,138
        // ============================================================
        $this->updateBookedSlot(13, 1, '13:30:00', '14:00:00', 136);
        $this->updateBookedSlot(13, 3, '14:30:00', '15:00:00', 136);
        $this->updateBookedSlot(13, 5, '13:30:00', '14:00:00', 136);
        $this->updateBookedSlot(13, 1, '15:00:00', '15:30:00', 137);
        $this->updateBookedSlot(13, 3, '16:00:00', '16:30:00', 137);
        $this->updateBookedSlot(13, 5, '15:30:00', '16:00:00', 137);
        $this->updateBookedSlot(13, 1, '16:30:00', '17:00:00', 138);
        $this->updateBookedSlot(13, 3, '17:30:00', '18:00:00', 138);
        $this->updateBookedSlot(13, 5, '17:00:00', '17:30:00', 138);

        // ============================================================
        // DOCTOR 14 (Schedule: g) - Patient: 139,140,141
        // ============================================================
        $this->updateBookedSlot(14, 2, '07:30:00', '08:00:00', 139);
        $this->updateBookedSlot(14, 4, '08:00:00', '08:30:00', 139);
        $this->updateBookedSlot(14, 6, '07:30:00', '08:00:00', 139);
        $this->updateBookedSlot(14, 2, '09:00:00', '09:30:00', 140);
        $this->updateBookedSlot(14, 4, '09:30:00', '10:00:00', 140);
        $this->updateBookedSlot(14, 6, '09:00:00', '09:30:00', 140);
        $this->updateBookedSlot(14, 2, '10:30:00', '11:00:00', 141);
        $this->updateBookedSlot(14, 4, '10:30:00', '11:00:00', 141);
        $this->updateBookedSlot(14, 6, '10:30:00', '11:00:00', 141);

        // ============================================================
        // DOCTOR 15 (Schedule: a) - Patient: 142,143,144
        // ============================================================
        $this->updateBookedSlot(15, 1, '09:30:00', '10:00:00', 142);
        $this->updateBookedSlot(15, 3, '09:00:00', '09:30:00', 142);
        $this->updateBookedSlot(15, 5, '11:00:00', '11:30:00', 142);
        $this->updateBookedSlot(15, 1, '11:00:00', '11:30:00', 143);
        $this->updateBookedSlot(15, 2, '10:00:00', '10:30:00', 143);
        $this->updateBookedSlot(15, 4, '10:30:00', '11:00:00', 143);
        $this->updateBookedSlot(15, 2, '14:30:00', '15:00:00', 144);
        $this->updateBookedSlot(15, 3, '13:30:00', '14:00:00', 144);
        $this->updateBookedSlot(15, 5, '14:00:00', '14:30:00', 144);

        // ============================================================
        // DOCTOR 16 (Schedule: b) - Patient: 145,146,147
        // ============================================================
        $this->updateBookedSlot(16, 1, '13:30:00', '14:00:00', 145);
        $this->updateBookedSlot(16, 3, '14:30:00', '15:00:00', 145);
        $this->updateBookedSlot(16, 5, '15:30:00', '16:00:00', 145);
        $this->updateBookedSlot(16, 1, '15:00:00', '15:30:00', 146);
        $this->updateBookedSlot(16, 2, '14:00:00', '14:30:00', 146);
        $this->updateBookedSlot(16, 4, '13:30:00', '14:00:00', 146);
        $this->updateBookedSlot(16, 2, '16:00:00', '16:30:00', 147);
        $this->updateBookedSlot(16, 3, '15:30:00', '16:00:00', 147);
        $this->updateBookedSlot(16, 5, '17:00:00', '17:30:00', 147);

        // ============================================================
        // DOCTOR 17 (Schedule: c) - Patient: 148,149,150
        // ============================================================
        $this->updateBookedSlot(17, 1, '07:30:00', '08:00:00', 148);
        $this->updateBookedSlot(17, 3, '08:00:00', '08:30:00', 148);
        $this->updateBookedSlot(17, 5, '07:30:00', '08:00:00', 148);
        $this->updateBookedSlot(17, 1, '09:00:00', '09:30:00', 149);
        $this->updateBookedSlot(17, 2, '08:30:00', '09:00:00', 149);
        $this->updateBookedSlot(17, 4, '09:00:00', '09:30:00', 149);
        $this->updateBookedSlot(17, 2, '10:00:00', '10:30:00', 150);
        $this->updateBookedSlot(17, 3, '09:30:00', '10:00:00', 150);
        $this->updateBookedSlot(17, 5, '10:00:00', '10:30:00', 150);

        // ============================================================
        // DOCTOR 18 (Schedule: d) - Patient: 151,152,153
        // ============================================================
        $this->updateBookedSlot(18, 1, '09:30:00', '10:00:00', 151);
        $this->updateBookedSlot(18, 3, '10:00:00', '10:30:00', 151);
        $this->updateBookedSlot(18, 5, '09:30:00', '10:00:00', 151);
        $this->updateBookedSlot(18, 1, '11:00:00', '11:30:00', 152);
        $this->updateBookedSlot(18, 3, '13:30:00', '14:00:00', 152);
        $this->updateBookedSlot(18, 5, '14:00:00', '14:30:00', 152);
        $this->updateBookedSlot(18, 1, '14:30:00', '15:00:00', 153);
        $this->updateBookedSlot(18, 3, '15:30:00', '16:00:00', 153);
        $this->updateBookedSlot(18, 5, '15:30:00', '16:00:00', 153);

        // ============================================================
        // DOCTOR 19 (Schedule: e) - Patient: 154,155,156
        // ============================================================
        $this->updateBookedSlot(19, 2, '09:30:00', '10:00:00', 154);
        $this->updateBookedSlot(19, 4, '10:00:00', '10:30:00', 154);
        $this->updateBookedSlot(19, 6, '09:30:00', '10:00:00', 154);
        $this->updateBookedSlot(19, 2, '11:00:00', '11:30:00', 155);
        $this->updateBookedSlot(19, 4, '13:30:00', '14:00:00', 155);
        $this->updateBookedSlot(19, 6, '14:00:00', '14:30:00', 155);
        $this->updateBookedSlot(19, 2, '14:30:00', '15:00:00', 156);
        $this->updateBookedSlot(19, 4, '15:30:00', '16:00:00', 156);
        $this->updateBookedSlot(19, 6, '15:30:00', '16:00:00', 156);

        // ============================================================
        // DOCTOR 20 (Schedule: f) - Patient: 157,158,159
        // ============================================================
        $this->updateBookedSlot(20, 1, '13:30:00', '14:00:00', 157);
        $this->updateBookedSlot(20, 3, '14:30:00', '15:00:00', 157);
        $this->updateBookedSlot(20, 5, '13:30:00', '14:00:00', 157);
        $this->updateBookedSlot(20, 1, '15:00:00', '15:30:00', 158);
        $this->updateBookedSlot(20, 3, '16:00:00', '16:30:00', 158);
        $this->updateBookedSlot(20, 5, '15:30:00', '16:00:00', 158);
        $this->updateBookedSlot(20, 1, '16:30:00', '17:00:00', 159);
        $this->updateBookedSlot(20, 3, '17:30:00', '18:00:00', 159);
        $this->updateBookedSlot(20, 5, '17:00:00', '17:30:00', 159);

        // ============================================================
        // DOCTOR 21 (Schedule: g) - Patient: 160,161,162
        // ============================================================
        $this->updateBookedSlot(21, 2, '07:30:00', '08:00:00', 160);
        $this->updateBookedSlot(21, 4, '08:00:00', '08:30:00', 160);
        $this->updateBookedSlot(21, 6, '07:30:00', '08:00:00', 160);
        $this->updateBookedSlot(21, 2, '09:00:00', '09:30:00', 161);
        $this->updateBookedSlot(21, 4, '09:30:00', '10:00:00', 161);
        $this->updateBookedSlot(21, 6, '09:00:00', '09:30:00', 161);
        $this->updateBookedSlot(21, 2, '10:30:00', '11:00:00', 162);
        $this->updateBookedSlot(21, 4, '10:30:00', '11:00:00', 162);
        $this->updateBookedSlot(21, 6, '10:30:00', '11:00:00', 162);

        // ============================================================
        // DOCTOR 22 (Schedule: a) - Patient: 163,164,165
        // ============================================================
        $this->updateBookedSlot(22, 1, '09:30:00', '10:00:00', 163);
        $this->updateBookedSlot(22, 3, '09:00:00', '09:30:00', 163);
        $this->updateBookedSlot(22, 5, '11:00:00', '11:30:00', 163);
        $this->updateBookedSlot(22, 1, '11:00:00', '11:30:00', 164);
        $this->updateBookedSlot(22, 2, '10:00:00', '10:30:00', 164);
        $this->updateBookedSlot(22, 4, '10:30:00', '11:00:00', 164);
        $this->updateBookedSlot(22, 2, '14:30:00', '15:00:00', 165);
        $this->updateBookedSlot(22, 3, '13:30:00', '14:00:00', 165);
        $this->updateBookedSlot(22, 5, '14:00:00', '14:30:00', 165);

        // ============================================================
        // DOCTOR 23 (Schedule: b) - Patient: 166,167,168
        // ============================================================
        $this->updateBookedSlot(23, 1, '13:30:00', '14:00:00', 166);
        $this->updateBookedSlot(23, 3, '14:30:00', '15:00:00', 166);
        $this->updateBookedSlot(23, 5, '15:30:00', '16:00:00', 166);
        $this->updateBookedSlot(23, 1, '15:00:00', '15:30:00', 167);
        $this->updateBookedSlot(23, 2, '14:00:00', '14:30:00', 167);
        $this->updateBookedSlot(23, 4, '13:30:00', '14:00:00', 167);
        $this->updateBookedSlot(23, 2, '16:00:00', '16:30:00', 168);
        $this->updateBookedSlot(23, 3, '15:30:00', '16:00:00', 168);
        $this->updateBookedSlot(23, 5, '17:00:00', '17:30:00', 168);

        // ============================================================
        // DOCTOR 24 (Schedule: c) - Patient: 169,170,171
        // ============================================================
        $this->updateBookedSlot(24, 1, '07:30:00', '08:00:00', 169);
        $this->updateBookedSlot(24, 3, '08:00:00', '08:30:00', 169);
        $this->updateBookedSlot(24, 5, '07:30:00', '08:00:00', 169);
        $this->updateBookedSlot(24, 1, '09:00:00', '09:30:00', 170);
        $this->updateBookedSlot(24, 2, '08:30:00', '09:00:00', 170);
        $this->updateBookedSlot(24, 4, '09:00:00', '09:30:00', 170);
        $this->updateBookedSlot(24, 2, '10:00:00', '10:30:00', 171);
        $this->updateBookedSlot(24, 3, '09:30:00', '10:00:00', 171);
        $this->updateBookedSlot(24, 5, '10:00:00', '10:30:00', 171);

        // ============================================================
        // DOCTOR 25 (Schedule: d) - Patient: 172,173,174
        // ============================================================
        $this->updateBookedSlot(25, 1, '09:30:00', '10:00:00', 172);
        $this->updateBookedSlot(25, 3, '10:00:00', '10:30:00', 172);
        $this->updateBookedSlot(25, 5, '09:30:00', '10:00:00', 172);
        $this->updateBookedSlot(25, 1, '11:00:00', '11:30:00', 173);
        $this->updateBookedSlot(25, 3, '13:30:00', '14:00:00', 173);
        $this->updateBookedSlot(25, 5, '14:00:00', '14:30:00', 173);
        $this->updateBookedSlot(25, 1, '14:30:00', '15:00:00', 174);
        $this->updateBookedSlot(25, 3, '15:30:00', '16:00:00', 174);
        $this->updateBookedSlot(25, 5, '15:30:00', '16:00:00', 174);

        // ============================================================
        // DOCTOR 26 (Schedule: e) - Patient: 175,176,177
        // ============================================================
        $this->updateBookedSlot(26, 2, '09:30:00', '10:00:00', 175);
        $this->updateBookedSlot(26, 4, '10:00:00', '10:30:00', 175);
        $this->updateBookedSlot(26, 6, '09:30:00', '10:00:00', 175);
        $this->updateBookedSlot(26, 2, '11:00:00', '11:30:00', 176);
        $this->updateBookedSlot(26, 4, '13:30:00', '14:00:00', 176);
        $this->updateBookedSlot(26, 6, '14:00:00', '14:30:00', 176);
        $this->updateBookedSlot(26, 2, '14:30:00', '15:00:00', 177);
        $this->updateBookedSlot(26, 4, '15:30:00', '16:00:00', 177);
        $this->updateBookedSlot(26, 6, '15:30:00', '16:00:00', 177);

        // ============================================================
        // DOCTOR 27 (Schedule: f) - Patient: 178,179,180
        // ============================================================
        $this->updateBookedSlot(27, 1, '13:30:00', '14:00:00', 178);
        $this->updateBookedSlot(27, 3, '14:30:00', '15:00:00', 178);
        $this->updateBookedSlot(27, 5, '13:30:00', '14:00:00', 178);
        $this->updateBookedSlot(27, 1, '15:00:00', '15:30:00', 179);
        $this->updateBookedSlot(27, 3, '16:00:00', '16:30:00', 179);
        $this->updateBookedSlot(27, 5, '15:30:00', '16:00:00', 179);
        $this->updateBookedSlot(27, 1, '16:30:00', '17:00:00', 180);
        $this->updateBookedSlot(27, 3, '17:30:00', '18:00:00', 180);
        $this->updateBookedSlot(27, 5, '17:00:00', '17:30:00', 180);

        // ============================================================
        // DOCTOR 28 (Schedule: g) - Patient: 181,182,183
        // ============================================================
        $this->updateBookedSlot(28, 2, '07:30:00', '08:00:00', 181);
        $this->updateBookedSlot(28, 4, '08:00:00', '08:30:00', 181);
        $this->updateBookedSlot(28, 6, '07:30:00', '08:00:00', 181);
        $this->updateBookedSlot(28, 2, '09:00:00', '09:30:00', 182);
        $this->updateBookedSlot(28, 4, '09:30:00', '10:00:00', 182);
        $this->updateBookedSlot(28, 6, '09:00:00', '09:30:00', 182);
        $this->updateBookedSlot(28, 2, '10:30:00', '11:00:00', 183);
        $this->updateBookedSlot(28, 4, '10:30:00', '11:00:00', 183);
        $this->updateBookedSlot(28, 6, '10:30:00', '11:00:00', 183);

        // ============================================================
        // DOCTOR 29 (Schedule: a) - Patient: 184,185,186
        // ============================================================
        $this->updateBookedSlot(29, 1, '09:30:00', '10:00:00', 184);
        $this->updateBookedSlot(29, 3, '09:00:00', '09:30:00', 184);
        $this->updateBookedSlot(29, 5, '11:00:00', '11:30:00', 184);
        $this->updateBookedSlot(29, 1, '11:00:00', '11:30:00', 185);
        $this->updateBookedSlot(29, 2, '10:00:00', '10:30:00', 185);
        $this->updateBookedSlot(29, 4, '10:30:00', '11:00:00', 185);
        $this->updateBookedSlot(29, 2, '14:30:00', '15:00:00', 186);
        $this->updateBookedSlot(29, 3, '13:30:00', '14:00:00', 186);
        $this->updateBookedSlot(29, 5, '14:00:00', '14:30:00', 186);

        // ============================================================
        // DOCTOR 30 (Schedule: b) - Patient: 187,188,189
        // ============================================================
        $this->updateBookedSlot(30, 1, '13:30:00', '14:00:00', 187);
        $this->updateBookedSlot(30, 3, '14:30:00', '15:00:00', 187);
        $this->updateBookedSlot(30, 5, '15:30:00', '16:00:00', 187);
        $this->updateBookedSlot(30, 1, '15:00:00', '15:30:00', 188);
        $this->updateBookedSlot(30, 2, '14:00:00', '14:30:00', 188);
        $this->updateBookedSlot(30, 4, '13:30:00', '14:00:00', 188);
        $this->updateBookedSlot(30, 2, '16:00:00', '16:30:00', 189);
        $this->updateBookedSlot(30, 3, '15:30:00', '16:00:00', 189);
        $this->updateBookedSlot(30, 5, '17:00:00', '17:30:00', 189);

        // ============================================================
        // DOCTOR 31 (Schedule: c) - Patient: 190,191,192
        // ============================================================
        $this->updateBookedSlot(31, 1, '07:30:00', '08:00:00', 190);
        $this->updateBookedSlot(31, 3, '08:00:00', '08:30:00', 190);
        $this->updateBookedSlot(31, 5, '07:30:00', '08:00:00', 190);
        $this->updateBookedSlot(31, 1, '09:00:00', '09:30:00', 191);
        $this->updateBookedSlot(31, 2, '08:30:00', '09:00:00', 191);
        $this->updateBookedSlot(31, 4, '09:00:00', '09:30:00', 191);
        $this->updateBookedSlot(31, 2, '10:00:00', '10:30:00', 192);
        $this->updateBookedSlot(31, 3, '09:30:00', '10:00:00', 192);
        $this->updateBookedSlot(31, 5, '10:00:00', '10:30:00', 192);
    }

    private function updateBookedSlot($doctorId, $dayId, $startTime, $endTime, $patientId)
    {
        $schedule = StaffSchedule::where('schedulable_type', 'App\Models\Doctor')
            ->where('schedulable_id', $doctorId)
            ->where('day_id', $dayId)
            ->where('is_working', 1)
            ->first();

        if (!$schedule) {
            return;
        }

        // 1 oy uchun
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        
        // Hafta kuniga mos keladigan birinchi sana
        $currentDate = $startDate->copy();
        while ($currentDate->dayOfWeek != $dayId) {
            $currentDate->addDay();
        }

        // 1 oy davomida har hafta
        while ($currentDate <= $endDate) {
            AppointmentSlot::where('staff_schedule_id', $schedule->id)
                ->where('date', $currentDate->toDateString())
                ->where('start_time', $startTime)
                ->where('end_time', $endTime)
                ->update([
                    'status' => 'booked',
                    'patient_id' => $patientId,
                ]);
            
            $currentDate->addWeek();
        }
    }
}