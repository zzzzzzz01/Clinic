<?php

namespace App\Services;

use App\Models\Doctor;
use App\Models\Department;
use App\Models\StaffSchedule;
use App\Models\AppointmentSlot;
use Carbon\Carbon;

class AppointmentService
{
    public function getAppointmentData($slug, $doctorId, $selectedDate = null) 
    {
        $department = Department::where('slug', $slug)->firstOrFail();

        $doctor = Doctor::with('user')->findOrFail($doctorId);

        $today = now()->toDateString();

        $selectedDate = $selectedDate ?? $today;

        $staffScheduleIds = StaffSchedule::where('schedulable_type', Doctor::class)
            ->where('schedulable_id', $doctorId)
            ->pluck('id');

        $slots = AppointmentSlot::whereIn('staff_schedule_id', $staffScheduleIds)
            ->whereDate('date', $selectedDate)
            ->orderBy('start_time')
            ->get();

        return compact(
            'department',
            'doctor',
            'today',
            'selectedDate',
            'slots'
        );
    }

    public function formatSlots($slots, $today, $selectedSlotId = null)
    {
        return $slots->map(function ($slot) use ($today, $selectedSlotId) {

            $slot->is_booked = $slot->status === 'booked';
            $slot->is_passed = $slot->date < $today;
            $slot->is_selected = $selectedSlotId == $slot->id;

            $slot->start = Carbon::parse($slot->start_time)->format('H:i');
            $slot->end = Carbon::parse($slot->end_time)->format('H:i');

            return $slot;
        });
    }
}