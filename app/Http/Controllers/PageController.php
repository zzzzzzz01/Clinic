<?php

namespace App\Http\Controllers; 

use App\Models\Faq;
use App\Models\Day; 
use App\Models\Doctor;  
use App\Models\Category;  
use App\Models\Procedure; 
use App\Models\Department;
use App\Models\Panel;
use App\Models\Post;
use App\Models\Patient;
use App\Models\DepartmentFeature;
use App\Models\DepartmentDisease;
use App\Models\StaffSchedule;
use App\Models\Appointment;
use App\Models\AppointmentSlot;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request; 


use Illuminate\Support\Str;
use App\Services\PageService;
use App\Services\PostService;
use App\Services\ScheduleService;
use App\Services\AppointmentService;

use Illuminate\Support\Facades\Hash;

class PageController extends Controller
{
    protected $scheduleService, $pageService, $postService, $appointmentService;

    public function __construct(ScheduleService $scheduleService, PageService $pageService, PostService $postService, AppointmentService $appointmentService)
    {
        $this->scheduleService = $scheduleService;
        $this->pageService = $pageService;
        $this->postService = $postService;
        $this->appointmentService = $appointmentService;
    }

    public function index()
    {
        // $user = auth()->user();
        $departments = Department::orderBy('created_at', 'desc')->limit(3)->get();

        $headDoctors = Doctor::whereHas('departments', function ($query) {
            $query->where('is_head', 1);
        })->get();

        $popularPosts = Post::orderByDesc('views')
            ->take(3)
            ->get();

        return view('index', compact('departments', 'headDoctors', 'popularPosts'));
    }

    public function services(Request $request)
    {
        // dd($request);
        $query = trim($request->q);

        $departments = Department::query();

        if (!empty($query)) {
            $departments->where(function ($q) use ($query) {
                $q->where('name_uz', 'like', "%{$query}%")
                ->orWhere('name_ru', 'like', "%{$query}%")
                ->orWhere('name_en', 'like', "%{$query}%")
                ->orWhere('description_uz', 'like', "%{$query}%")
                ->orWhere('description_ru', 'like', "%{$query}%")
                ->orWhere('description_en', 'like', "%{$query}%");
            });
        }

        $departments = $departments->paginate(9);

        return view('services', compact('departments'));
    }

    public function serviceDetail($slug){
        $department = Department::where('slug', $slug)->first(); 
        $features = DepartmentFeature::where('department_id', $department->id)
            ->orderBy('sort_order')
            ->get();
        
        $diseases = DepartmentDisease::where('department_id', $department->id)
            ->orderBy('sort_order')
            ->get();

        $procedures = Procedure::where('department_id', $department->id)
            ->orderBy('created_at')
            ->get();

        $panels = Panel::where('department_id', $department->id)
            ->orderBy('created_at')
            ->get();

        $doctors = Doctor::whereHas('departments', function ($q) use ($department) {
            $q->where('departments.id', $department->id);
        })
        ->with('user')
        ->get();
        return view('service-detail', compact('department', 'features', 'diseases', 'procedures', 'panels', 'doctors'));
    }

    public function serviceAppointment(Request $request, $slug, $doctorId)
    {
        $data = $this->appointmentService->getAppointmentData(
            $slug,
            $doctorId,
            $request->date
        );

        $data['slots'] = $this->appointmentService->formatSlots(
            $data['slots'],
            $data['today'],
            $request->slot_id
        );

        $data['isFromServicesPage'] = str_contains(
            url()->previous(),
            route('services.page')
        );

        return view('service-appointment', $data);
    }


    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'slot_id' => 'required|exists:appointment_slots,id',
            'date' => 'required|date',
            'reason' => 'required|string|max:500',
            'department_id' => 'required|exists:departments,id',
        ]);
    
        $slot = AppointmentSlot::findOrFail($request->slot_id);
        $patient = Patient::where('user_id', auth()->id())->firstOrFail();
        $department = Department::findOrFail($request->department_id);
    
        if ($slot->status === 'booked') {
            return back()->with('error', 'Bu vaqt allaqachon band qilingan.');
        }
    
        DB::transaction(function () use ($request, $slot, $patient) {
    
            Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $request->doctor_id,
                'appointment_slot_id' => $request->slot_id,
                'date' => $request->date,
                'reason' => $request->reason,
                'status' => 'booked',
            ]);
    
            $slot->update([
                'status' => 'booked',
                'patient_id' => $patient->id,
            ]);
        });
    
        foreach (['uz', 'ru', 'en'] as $locale) {
            Cache::forget("patient_appointments_{$patient->id}_{$locale}");
        }
    
        return redirect()->route('services.detail', $department->slug)
            ->with('success', 'Qabul muvaffaqiyatli yaratildi!');
    }
    
    public function patientAppointments()
    {
        $patient = Patient::where('user_id', auth()->id())->firstOrFail();
    
        $locale = app()->getLocale();
    
        $appointments = Cache::rememberForever(
            "patient_appointments_{$patient->id}_{$locale}",
            function () {
                return $this->pageService->patientAppointments();
            }
        );
    
        return view('patient-appointments', compact('appointments'));
    }

    public function patientAppointmentShow(Appointment $appointment)
    {
        $patient = Patient::where('user_id', auth()->id())->firstOrFail();

        $locale = app()->getLocale();

        $formattedAppointment = Cache::rememberForever(
            "patient_appointment_show_{$patient->id}_{$appointment->id}_{$locale}",
            function () use ($appointment) {
                return $this->pageService->getSingleAppointment($appointment);
            }
        );

        $prescriptions = $formattedAppointment['prescriptions'];

        return view('patient-appointment-show', compact(
            'formattedAppointment',
            'prescriptions'
        ));
    }


    public function about()
    {
        return view('about');
    }

    public function cardiology()
    {
        return view('cardiology');
    }

    public function blog()
    {
        return view('blogs', $this->postService->blogData());
    }

    public function detail($id)
    {
        $data = $this->postService->blogDetailData($id);
        // dd($data);
        return view('blogs-detail', $data);
    }
 
    public function blogCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        // Kategoriyaga tegishli postlarni olamiz
        $posts = Post::where('category_id', $category->id)
                    ->with(['category', 'comments'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        
        // Service dan ma'lumotlarni olamiz
        $data = $this->postService->getcategoryPosts();
        
        // $data ni ochib, alohida o'zgaruvchilarga ajratamiz
        $tags = $data['tags'];
        $categories = $data['categories'];
        $popularPosts = $data['popularPosts'];

        return view('blog-category-posts', compact('posts', 'tags', 'categories', 'popularPosts', 'category'));
    }

    public function contact() {
        return view('contact');
    }

    public function chiefDoctors()
    {
        return view('doctors');
    }

    public function question()
    {
        $faqs = Faq::where('status', 1)
        ->orderBy('sort_order')
        ->get(); 

        return view('questions', compact('faqs'));
    } 

    public function language($lang)
    {
        session(['lang'=> $lang]);
        return back();
    }

    public function schedule($type, $id)
    {
        $schedulable = $this->scheduleService->findSchedulable($type, $id);
        
        $staffSchedules = \App\Models\StaffSchedule::where([
            'schedulable_id' => $schedulable->id,
            'schedulable_type' => get_class($schedulable),
        ])->get()->keyBy('day_id');
        
        $hasSchedule = $staffSchedules->isNotEmpty();
        
        $daysOfWeek = \App\Models\Day::all();
        
        foreach ($daysOfWeek as $day) {
            $day->schedule = $this->scheduleService->getDefaultForDay(
                $staffSchedules->get($day->id),
                $day->id
            );
        }
        
        $stats = $this->scheduleService->getStatistics($staffSchedules);
        
        return view('dashboard.doctors.schedule', [
            'schedulable' => $schedulable,
            'type' => $type,
            'daysOfWeek' => $daysOfWeek,
            'hasSchedule' => $hasSchedule,
            'workingDaysCount' => $stats['working_days_count'],
            'totalWorkingHours' => $stats['total_working_hours'],
        ]);
    }

    private function calculateTotalHours($schedules)
    {
        $total = 0;
        foreach ($schedules as $schedule) {
            if ($schedule->is_working && $schedule->start_time && $schedule->end_time) {
                $start = strtotime($schedule->start_time);
                $end = strtotime($schedule->end_time);
                $total += ($end - $start) / 3600;
            }
        }
        return $total;
    }

    /**
     * Bitta metod - ham CREATE, ham UPDATE
     */
    public function saveSchedule(Request $request, $type, $id)
    {
        $schedulable = $this->scheduleService->findSchedulable($type, $id);
        
        // Bo'sh stringlarni null ga o'zgartirish
        $days = $request->input('days', []);
        foreach ($days as $dayId => $dayData) {
            foreach (['start_time', 'end_time', 'lunch_start', 'lunch_end'] as $field) {
                if (isset($dayData[$field]) && $dayData[$field] === '') {
                    $days[$dayId][$field] = null;
                }
            }
        }
        $request->merge(['days' => $days]);
        
        // Validatsiya
        $validated = $request->validate($this->scheduleService->validationRules());
        // dd($validated);
        
        // Mavjud schedule bormi tekshirish
        $hasExistingSchedule = \App\Models\StaffSchedule::where([
            'schedulable_id' => $schedulable->id,
            'schedulable_type' => get_class($schedulable),
        ])->exists();
        
        // Saqlash
        $result = $this->scheduleService->saveOrUpdate($schedulable, $validated['days'], $hasExistingSchedule);
        
        // Xabar tayyorlash
        $message = '';
        
        if ($result['saved'] > 0) {
            $daysList = implode(', ', $result['saved_days']);
            if ($result['saved'] == 1) {
                $message = "{$daysList} kuni jadval saqlandi!";
            } else {
                $message = "{$daysList} kunlari jadval saqlandi!";
            }
        }
        
        if ($result['updated'] > 0) {
            $daysList = implode(', ', $result['updated_days']);
            if ($result['updated'] == 1) {
                $message .= ($message ? ' ' : '') . "{$daysList} kuni jadval yangilandi!";
            } else {
                $message .= ($message ? ' ' : '') . "{$daysList} kunlari jadval yangilandi!";
            }
        }
        
        if (empty($message)) {
            $message = 'Hech qanday o\'zgarish yo\'q';
        }
        
        return back()->with('success', $message);
    }

    public function profil()
    {
        return view('dashboard.profil.index');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Hozirgi parol noto‘g‘ri']);
        }
        
        auth()->user()->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Parol muvaffaqiyatli o‘zgartirildi.');
    }

    public function personalData()
    {
        $data = $this->pageService->getPersonalData();
        return view('dashboard.profil.personal-data', $data);
    }
}
