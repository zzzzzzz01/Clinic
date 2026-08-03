<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Doctor; 
use App\Models\Nurse;
use App\Models\StaffSchedule;
use App\Models\AppointmentSlot;
use Illuminate\Http\Request;
use App\Services\AppointmentSlotService;

class AppointmentSlotController extends Controller
{
    public function __construct(
        private AppointmentSlotService $slotService
    ) {}
 
    public function create(Request $request, string $type, int $id)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);
 
        // Eager loading bilan user munosabatini bitta queryda olamiz
        $schedulable = match ($type) {
            'doctor' => Doctor::with('user')->findOrFail($id),
            'nurse'  => Nurse::with('user')->findOrFail($id),
            default  => abort(404),
        };
 
        $days = $this->slotService->generateSlotsForPeriod(
            $schedulable,
            $request->start_date,
            $request->end_date
        );
 
        return view('dashboard.doctors.appointmentSlots.create', compact('schedulable', 'days', 'type'));
    }
 
    public function store(Request $request, $type, $id)
    {
        try {
            // 1️⃣ Schedulable aniqlash
            if ($type === 'doctor') {
                $schedulable = Doctor::findOrFail($id);
                $redirectRoute = route('doctor.appointment.slots', $schedulable);
            } elseif ($type === 'nurse') {
                $schedulable = Nurse::findOrFail($id);
                $redirectRoute = route('nurse.appointment.slots', $schedulable);
            } else {
                abort(404);
            }
        
            // 2️⃣ Validation
            $request->validate([
                'selected_slots' => 'nullable|array',
                'working_days' => 'nullable|array',
            ]);
        
            $selectedSlots = $request->input('selected_slots', []);
            $workingDays = $request->input('working_days', []);
        
            // 3️ Service orqali slotlarni saqlash
            $result = $this->slotService->storeSlots($schedulable, $selectedSlots, $workingDays);
        
            // 4️ Natija xabarini tayyorlash
            $message = $this->getResultMessage($result['saved'], $result['skipped'], $result['disabled']);
        
            return redirect($redirectRoute)->with('success', $message);
            
        } catch (\Exception $e) {
            \Log::error('Slot yaratishda xatolik: ' . $e->getMessage());
            return back()->with('error', __('words.slot_create_error') . ': ' . $e->getMessage());
        }
    }

    /**
     * Natija xabarini tayyorlash (Lokalizatsiya qilingan)
     */
    private function getResultMessage($savedCount, $skippedCount, $disabledCount)
    {
        $messages = [];
        
        if ($savedCount > 0) {
            $messages[] = $savedCount . ' ' . __('words.slots_created');
        }
        
        if ($skippedCount > 0) {
            $messages[] = $skippedCount . ' ' . __('words.slots_already_exist');
        }
        
        if ($disabledCount > 0) {
            $messages[] = $disabledCount . ' ' . __('words.slots_not_created_switch_off');
        }
        
        if (empty($messages)) {
            return __('words.no_new_slots_created');
        }
        
        return implode(", ", $messages);
    }
}