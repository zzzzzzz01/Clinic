<?php

namespace App\Http\Controllers; 

use Carbon\Carbon; 
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\StaffSchedule;
use App\Models\AppointmentSlot;
use App\Services\ReceptionistService;
use Illuminate\Http\Request;

class ReceptionistController extends Controller
{
    protected $receptionistService;

    public function __construct(ReceptionistService $receptionistService)
    {
        $this->receptionistService = $receptionistService;
    }

    public function index(Request $request)
    {
        $data = $this->receptionistService->getPatientsList($request);
        return view('dashboard.receptionist.patients', $data);
    }

    public function create(Patient $patient)
    { 
        $departments = Department::all();
        $today = Carbon::today()->format('Y-m-d');
        
        return view('dashboard.receptionist.create', compact('patient', 'departments', 'today'));
    }

    // AJAX: Department bo'yicha doctorlarni olish
    public function getDoctorsByDepartment($departmentId)
    {
        $doctors = Doctor::with('user')
            ->whereHas('departments', function ($query) use ($departmentId) {
                $query->where('departments.id', $departmentId);
            })
            ->get();
    
        return response()->json(
            $doctors->map(function ($doctor) {
                return [
                    'id' => $doctor->id,
                    'name' => 'Dr. ' . trim(($doctor->user->last_name ?? '') . ' ' . ($doctor->user->name ?? '')),
                ];
            })
        );
    }

    // AJAX: Doctor va sana bo'yicha slotlarni olish
    public function getSlotsByDoctorDate(Request $request)
    {
        $scheduleIds = StaffSchedule::where('schedulable_type', Doctor::class)
            ->where('schedulable_id', $request->doctor_id)
            ->where('is_working', 1)
            ->pluck('id');

        $slots = AppointmentSlot::whereIn('staff_schedule_id', $scheduleIds)
            ->whereDate('date', $request->date)
            ->orderBy('start_time')
            ->get();

        return response()->json(
            $slots->map(function ($slot) {
                return [
                    'id' => $slot->id,
                    'start_time' => Carbon::parse($slot->start_time)->format('H:i'),
                    'end_time'   => Carbon::parse($slot->end_time)->format('H:i'),
                    'status'     => $slot->status, // <-- ENG MUHIM QATOR
                ];
            })
        );
    }

    public function storeAppointment(Request $request)
    {
        $result = $this->receptionistService->createAppointment($request);
        
        if ($result['success']) {
            return redirect()->route('receptionist.index')
                ->with('success', $result['message']);
        }
        
        return back()->with('error', $result['message'])->withInput();
    }
}