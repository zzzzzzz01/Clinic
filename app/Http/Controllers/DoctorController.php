<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Doctor; 
use App\Models\Patient;
use App\Models\Department;
use App\Models\AppointmentSlot;
use App\Models\Appointment;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Services\DoctorService; 
use App\Services\DoctorAppointmentService;

class DoctorController extends Controller
{
    protected $appointmentService;
    protected $doctorService;

    public function __construct(DoctorAppointmentService $appointmentService, DoctorService $doctorService)
    {
        $this->appointmentService = $appointmentService;
        $this->doctorService = $doctorService;
    }

    /**
     * INDEX - Shifokorlar ro'yxati
     */
    public function index(Request $request)
    {
        // dd($request->all());
        $filters = [ 
            'search' => $request->search,
            'status' => $request->status ?? 'all',
            'department' => $request->department ?? 'all',
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
        ];
        
        $perPage = $request->get('per_page', 10);
        
        $data = $this->doctorService->getDoctors($filters, $perPage);
        $activeFiltersCount = $this->doctorService->getActiveFiltersCount($filters);
        
        return view('dashboard.doctors.index', array_merge($data, [
            'activeFiltersCount' => $activeFiltersCount,
            'currentFilters' => $filters,
        ]));
    }

    /**
     * CREATE - Yaratish formasi
     */
    public function create()
    {
        $departments = Department::all();
        return view('dashboard.doctors.create', compact('departments'));
    }

    /**
     * STORE - Yaratish
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'phone' => 'required|string|max:20|unique:users,phone',
                'email' => 'required|email|regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/|unique:users,email',
                'password' => 'required|string|min:6|max:8',
                'password_confirmation' => 'required|same:password',
                'passport_series' => 'nullable|string|max:9',
                'passport_number' => 'nullable|string|max:14',
                'gender' => 'nullable|in:male,female',
                'position' => 'nullable|string|max:255',
                'qualification' => 'nullable|string|max:255',
                'hire_date' => 'nullable|date',
                'specialization' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:500',
                'birth_date' => 'nullable|date',
                'experience_years' => 'nullable|integer|min:0|max:50',
                'education_university' => 'nullable|string|max:255',
                'education_specialization' => 'nullable|string|max:255',
                'education_level' => 'nullable|string|max:255',
                'graduation_date' => 'nullable|date',
                'department_id' => 'nullable|exists:departments,id',
                'bio' => 'nullable|string|max:1000',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            DB::beginTransaction();
            
            // Login generatsiya
            $login = $this->doctorService->generateLogin();
            
            // User yaratish
            $user = \App\Models\User::create([
                'name' => $validated['name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'role' => 'doctor',
                'login' => $login,
                'status' => 'active',
            ]);
            
            // Rasm yuklash
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('doctors', 'public');
            }
            
            // Doctor yaratish
            $doctor = Doctor::create([
                'user_id' => $user->id,
                'birth_date' => $validated['birth_date'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'passport_series' => $validated['passport_series'] ?? null,
                'passport_number' => $validated['passport_number'] ?? null,
                'address' => $validated['address'] ?? null,
                'specialization' => $validated['specialization'] ?? null,
                'position' => $validated['position'] ?? null,
                'qualification' => $validated['qualification'] ?? null,
                'experience_years' => $validated['experience_years'] ?? 0,
                'hire_date' => $validated['hire_date'] ?? null,
                'education_university' => $validated['education_university'] ?? null,
                'education_specialization' => $validated['education_specialization'] ?? null,
                'education_level' => $validated['education_level'] ?? null,
                'graduation_date' => $validated['graduation_date'] ?? null,
                'bio' => $validated['bio'] ?? null,
                'photo' => $photoPath,
                'status' => 'active',
            ]);
            
            // Department attach
            if (!empty($validated['department_id'])) {
                $department = Department::find($validated['department_id']);
                if ($department) {
                    $doctor->departments()->attach($department->id, ['is_head' => true]);
                }
            }
            
            DB::commit();
            $this->doctorService->clearDoctorsCache();
            
            return redirect()->route('doctors.index')
                ->with('success', __('words.doctor_created_successfully'));
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Doctor creation error: ' . $e->getMessage());
            return back()->with('error', __('words.doctor_create_error') . ': ' . $e->getMessage())->withInput();
        }
    }

    /**
     * SHOW - Batafsil ko'rish
     */
    public function show(Doctor $doctor)
    {
        $doctor->load(['user', 'departments']);
        $formattedDoctor = $this->doctorService->formatDoctorForView($doctor);
        
        return view('dashboard.doctors.show', [
            'doctor' => $doctor,
            'fd' => $formattedDoctor
        ]);
    }

    /**
     * EDIT - Tahrirlash formasi
     */
    public function edit(Doctor $doctor)
    {
        $departments = Department::all();
        $currentDepartment = $doctor->departments()->first();
        
        return view('dashboard.doctors.edit', compact('doctor', 'departments', 'currentDepartment'));
    }

    /**
     * UPDATE - Yangilash
     */
    public function update(Request $request, Doctor $doctor)
    {
        DB::beginTransaction();
        
        try {
            $rules = [
                'name' => 'sometimes|string|max:255',
                'last_name' => 'sometimes|string|max:255',
                'middle_name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|max:255|unique:users,email,' . $doctor->user_id,
                'phone' => 'sometimes|string|max:20',
                'passport_series' => 'sometimes|string|max:9',
                'passport_number' => 'sometimes|string|max:14|unique:doctors,passport_number,' . $doctor->id,
                'gender' => 'sometimes|in:male,female',
                'position' => 'sometimes|string|max:255',
                'qualification' => 'sometimes|string|max:255',
                'hire_date' => 'sometimes|date',
                'specialization' => 'sometimes|string|max:255',
                'address' => 'sometimes|string',
                'birth_date' => 'sometimes|date',
                'experience_years' => 'sometimes|integer|min:0|max:50',
                'education_university' => 'sometimes|string|max:255',
                'education_specialization' => 'sometimes|string|max:255',
                'education_level' => 'sometimes|string|max:255',
                'graduation_date' => 'sometimes|date',
                'bio' => 'sometimes|string',
                'photo' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'sometimes|in:active,inactive,on_leave',
            ];
            
            $validated = $request->validate($rules);
            
            // User yangilash
            $userData = array_intersect_key($validated, [
                'name' => true, 'last_name' => true, 'middle_name' => true,
                'email' => true, 'phone' => true,
            ]);
            if (!empty($userData)) {
                $doctor->user->update($userData);
            }
            
            // Rasm yangilash
            $photoPath = $doctor->photo;
            if ($request->hasFile('photo')) {
                if ($doctor->photo && \Storage::disk('public')->exists($doctor->photo)) {
                    \Storage::disk('public')->delete($doctor->photo);
                }
                $photoPath = $request->file('photo')->store('doctors', 'public');
            }
            
            // Doctor yangilash
            $doctorData = array_intersect_key($validated, [
                'passport_series' => true, 'passport_number' => true, 'gender' => true,
                'position' => true, 'qualification' => true, 'hire_date' => true,
                'specialization' => true, 'address' => true, 'birth_date' => true,
                'experience_years' => true, 'education_university' => true,
                'education_specialization' => true, 'education_level' => true,
                'graduation_date' => true, 'bio' => true, 'status' => true,
            ]);
            $doctorData['photo'] = $photoPath;
            $doctor->update($doctorData);
            
            DB::commit();
            $this->doctorService->clearDoctorsCache();
            
            return redirect()->route('doctors.edit', $doctor)
                ->with('success', __('words.doctor_updated_successfully'));
                
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Doctor update error: ' . $e->getMessage());
            return redirect()->route('doctors.edit', $doctor)
                ->with('error', __('words.doctor_update_error') . ': ' . $e->getMessage());
        }
    }

    /**
     * DESTROY - O'chirish
     */
    public function destroy(Doctor $doctor)
    {
        try {
            DB::beginTransaction();
            
            // Rasmni o'chirish
            if ($doctor->photo && \Storage::disk('public')->exists($doctor->photo)) {
                \Storage::disk('public')->delete($doctor->photo);
            }
            
            // Userni o'chirish
            if ($doctor->user) {
                $doctor->user->delete();
            }
            
            // Doctorni o'chirish
            $doctor->delete();
            
            DB::commit();
            $this->doctorService->clearDoctorsCache();
            
            return redirect()->route('doctors.index')
                ->with('success', __('words.doctor_deleted_successfully'));
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('doctors.index')
                ->with('error', __('words.doctor_delete_error') . ': ' . $e->getMessage());
        }
    }

    /**
     * Parolni passport raqamiga tiklash
     */
    public function resetPassword(Doctor $doctor)
    {
        try {
            DB::beginTransaction();
            
            if (empty($doctor->passport_number)) {
                throw new \Exception("Shifokorning passport raqami topilmadi!");
            }
            
            $newPassword = $doctor->passport_number;
            $doctor->user->password = bcrypt($newPassword);
            $doctor->user->save();
            
            DB::commit();
            $this->doctorService->clearDoctorsCache();
            
            return redirect()->route('doctors.edit', $doctor)
                ->with('success', 'Parol muvaffaqiyatli tiklandi!')
                ->with('password_cancelled', true)
                ->with('new_password', $newPassword);
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('doctors.edit', $doctor)
                ->with('error', __('words.password_reset_error') . ': ' . $e->getMessage());
        }
    }

    /**
     * Schedule sahifasi
     */
    public function schedule($type, $id)
    {
        if ($type === 'doctor') {
            $schedulable = Doctor::with('user')->findOrFail($id);
        } else {
            abort(404);
        }
        
        $daysOfWeek = \App\Models\DaysOfWeek::orderBy('order')->get();
        $schedules = \App\Models\StaffSchedule::where('staff_id', $schedulable->id)
            ->where('staff_type', Doctor::class)
            ->get()
            ->keyBy('day_of_week_id');
        
        $workingDaysCount = 0;
        $totalWorkingHours = 0;
        
        foreach ($daysOfWeek as $day) {
            if (isset($schedules[$day->id])) {
                $day->schedule = $schedules[$day->id];
                if ($day->schedule->is_working) {
                    $workingDaysCount++;
                    if ($day->schedule->start_time && $day->schedule->end_time) {
                        $start = Carbon::parse($day->schedule->start_time);
                        $end = Carbon::parse($day->schedule->end_time);
                        $totalWorkingHours += $start->diffInHours($end);
                    }
                }
            } else {
                $day->schedule = null;
            }
        }
        
        return view('dashboard.doctors.schedule', compact(
            'schedulable', 'type', 'daysOfWeek', 'workingDaysCount', 'totalWorkingHours'
        ));
    }

    /**
     * Schedule saqlash
     */
    public function saveSchedule(Request $request, $type, $id)
    {
        try {
            DB::beginTransaction();
            
            if ($type === 'doctor') {
                $schedulable = Doctor::findOrFail($id);
            } else {
                abort(404);
            }
            
            $days = $request->input('days', []);
            
            foreach ($days as $dayId => $data) {
                $isWorking = isset($data['is_working']) && $data['is_working'] == 1;
                
                \App\Models\StaffSchedule::updateOrCreate(
                    [
                        'staff_id' => $schedulable->id,
                        'staff_type' => get_class($schedulable),
                        'day_of_week_id' => $dayId
                    ],
                    [
                        'is_working' => $isWorking,
                        'start_time' => $isWorking ? ($data['start_time'] ?? null) : null,
                        'end_time' => $isWorking ? ($data['end_time'] ?? null) : null,
                        'lunch_start' => $isWorking ? ($data['lunch_start'] ?? null) : null,
                        'lunch_end' => $isWorking ? ($data['lunch_end'] ?? null) : null,
                        'appointment_duration' => $isWorking ? ($data['appointment_duration'] ?? 30) : null,
                    ]
                );
            }
            
            DB::commit();
            $this->doctorService->clearDoctorsCache();
            
            return redirect()->back()->with('success', __('words.schedule_saved_successfully'));
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Schedule save error: ' . $e->getMessage());
            return redirect()->back()->with('error', __('words.schedule_save_error') . ': ' . $e->getMessage());
        }
    }

    /**
     * Ambulator qabullar
     */
    public function ambulatorDoctor(Doctor $doctor, Request $request)
    {
        $selectedDate = $request->date ?? Carbon::today()->format('Y-m-d');
        
        $dates = $this->appointmentService->getWeekDates($selectedDate);
        $dateButtons = $this->appointmentService->prepareDateButtons($selectedDate);
        $selectedDateInfo = $this->appointmentService->getSelectedDateInfo($selectedDate); 
        $doctorSlots = $this->appointmentService->getDoctorSlots($doctor, $selectedDate);
        // dd($doctorSlots);
        $stats = $this->appointmentService->getStatistics($doctor, $selectedDate);
        $weekRange = $this->appointmentService->getWeekRange($dates);
        
        $patients = Patient::with('user')->get();
        
        return view('dashboard.doctors.ambulator', compact(
            'doctor', 'dateButtons', 'selectedDate', 'selectedDateInfo',
            'weekRange', 'doctorSlots', 'stats', 'patients'
        ));
    }

    public function doctorAppointmentSlots(Doctor $doctor, Request $request, DoctorAppointmentService $service)
    {
        $data = $service->getDoctorAppointmentSlots($doctor, $request);
    
        return view('dashboard.doctors.appointmentSlots.index', [
            'doctor' => $doctor,
            'doctorSlots' => $data['doctorSlots'],
            'formattedSlots' => $data['formattedSlots'],
            'stats' => $data['stats'],
            'selectedDate' => $data['selectedDate'],
        ]);
    }

    /**
     * Doctor appointment sahifasi
     */

     public function doctorAppointment(Request $request) 
    {
        $doctor = Doctor::where('user_id', auth()->id())->first();
        
        if (!$doctor) {
            return redirect()->route('dashboard.index')->with('error', 'Shifokor ma\'lumoti topilmadi');
        }
        
        $selectedDate = $request->get('date', Carbon::now()->format('Y-m-d'));
        $locale = app()->getLocale();
        
        // TAGS bilan cache key
        $cacheKey = "doctor_{$doctor->id}_{$selectedDate}_{$locale}";
        
        $data = Cache::tags(['doctors'])->remember($cacheKey, 600, function() use ($doctor, $selectedDate, $locale) {
            $doctorData = $this->doctorService->prepareDoctorData($doctor);
            $dates = $this->doctorService->getDatesList($selectedDate);
            $buttonData = $this->doctorService->getDateButtonText($selectedDate);
            
            $appointments = $this->doctorService->getDoctorAppointments($doctor, $selectedDate);
            $preparedAppointments = $this->doctorService->prepareAppointmentsData($appointments);
            
            $datesData = [];
            foreach ($dates as $date) {
                $datesData[] = $this->doctorService->prepareDateData($date, $selectedDate, $locale);
            }
            
            return [
                'doctorData' => $doctorData,
                'selectedDate' => $selectedDate,
                'buttonData' => $buttonData,
                'datesData' => $datesData,
                'appointments' => $preparedAppointments
            ];
        });
        
        return view('dashboard.doctors.appointments', $data);
    }

    public function consultation(Appointment $appointment, Request $request)
    {
        $departments = Department::all();
        $medicines = Medicine::all();
        // dd($appointment->id);
        
        return view('dashboard.doctors.consultation', compact('appointment', 'departments', 'medicines'));
    }

    public function doctorService(Request $request)
    {
        $query = Doctor::with('user');
        
        if ($request->has('q') && !empty($request->q)) {
            $searchTerm = $request->q;
            $query->whereHas('user', function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('last_name', 'LIKE', "%{$searchTerm}%");
            });
        }
        
        $doctors = $query->paginate(9);
        
        return view('doctors.index', compact('doctors'));
    }
}