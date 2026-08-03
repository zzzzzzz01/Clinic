<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Nurse;
use App\Models\Department;
use App\Services\NurseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use App\Models\HospitalizationPrescriptionItem;
use App\Models\HospitalizationPrescriptionItemSlot;
use App\Models\HospitalizationPrescriptionAdministration;
use App\Models\HospitalizationProcedure;

class NurseController extends Controller
{
    protected $nurseService;
    
    public function __construct(NurseService $nurseService)
    {
        $this->nurseService = $nurseService;
    }
    
    public function index(Request $request)
    {
        $data = $this->nurseService->getFilteredNurses($request);
        
        return view('dashboard.nurses.index', [
            'nurses' => $data['nurses'],
            'departments' => $data['departments'],
            'stats' => $data['stats'],
            'nursesWithStatus' => $data['nursesWithStatus']
        ]);
    }

    public function show(Nurse $nurse)
    {
        $nurse->load(['user', 'department']);
        $formattednurse = $this->nurseService->formatNurseForView($nurse);
        
        return view('dashboard.nurses.show', [
            'nurse' => $nurse,
            'fd' => $formattednurse
        ]);
    }

    public function create() 
    {
        $departments = Department::all();
        return view('dashboard.nurses.create', compact('departments'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'phone' => 'required|string|max:20|unique:users,phone',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|max:8',
                'password_confirmation' => 'required|same:password',
                'passport_series' => 'nullable|string|max:9',
                'passport_number' => 'nullable|string|max:14',
                'gender' => 'required|in:female,male',
                'position' => 'required|string|max:255',
                'qualification' => 'required|string|max:255',
                'hire_date' => 'required|date',
                'specialization' => 'required|string|max:255',
                'address' => 'nullable|string|max:500',
                'birth_date' => 'required|date',
                'experience_years' => 'required|integer|min:0|max:50',
                'education_university' => 'required|string|max:255',
                'education_specialization' => 'required|string|max:255',
                'education_level' => 'required|string|max:255',
                'graduation_date' => 'required|date',
                'department_id' => 'required|exists:departments,id',
                'bio' => 'nullable|string|max:1000',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            DB::beginTransaction();
            
            $login = $this->nurseService->generateLogin();
            
            $user = \App\Models\User::create([
                'name' => $validated['name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'role' => 'nurse',
                'login' => $login,
                'status' => 'active',
            ]);
            
            $user->roles()->attach(2);
            
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('nurses', 'public');
            }
            
            $nurse = Nurse::create([
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
                'department_id' => $validated['department_id'] ?? null,
                'bio' => $validated['bio'] ?? null,
                'photo' => $photoPath,
                'status' => 'active',
            ]);
            
            DB::commit();
            $this->nurseService->clearNursesCache();
            
            return redirect()->route('nurses.index')
                ->with('success', __('words.nurse_created_successfully'));
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->with('error', __('words.nurse_create_error'))
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Nurse creation error: ' . $e->getMessage());
            return back()->with('error', __('words.nurse_create_error'))->withInput();
        }
    }

    public function edit(Nurse $nurse)
    {
        // App()->getLocale() - joriy tilni avtomatik olish
        $departments = Department::select('id', 'name_' . app()->getLocale() . ' as name')->get();
        
        return view('dashboard.nurses.edit', compact('nurse', 'departments'));
    }

    public function update(Request $request, Nurse $nurse)
    {
        try {
            $validated = $request->validate([
                'name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'middle_name' => 'nullable|string|max:255',
                'email' => 'nullable|email|unique:users,email,' . $nurse->user_id,
                'phone' => 'nullable|string|max:20',
                'passport_series' => 'nullable|string|max:9',
                'passport_number' => 'nullable|string|max:14|unique:nurses,passport_number,' . $nurse->id,
                'gender' => 'nullable|in:male,female',
                'position' => 'nullable|string|max:255',
                'qualification' => 'nullable|string|max:255',
                'hire_date' => 'nullable|date',
                'specialization' => 'nullable|string|max:255',
                'address' => 'nullable|string',
                'birth_date' => 'nullable|date',
                'experience_years' => 'nullable|integer|min:0|max:50',
                'education_university' => 'nullable|string|max:255',
                'education_specialization' => 'nullable|string|max:255',
                'education_level' => 'nullable|string|max:255',
                'graduation_date' => 'nullable|date',
                'department_id' => 'nullable|exists:departments,id',
                'room_number' => 'nullable|string|max:50',
                'bio' => 'nullable|string',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'nullable|in:active,inactive,on_leave',
            ]);
    
            // User update
            $nurse->user->update($request->only(['name', 'last_name', 'middle_name', 'email', 'phone']));
    
            // Photo upload
            if ($request->hasFile('photo')) {
                if ($nurse->photo && \Storage::disk('public')->exists($nurse->photo)) {
                    \Storage::disk('public')->delete($nurse->photo);
                }
                $validated['photo'] = $request->file('photo')->storeAs('nurses', 
                    time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $request->file('photo')->getClientOriginalName()), 
                    'public'
                );
            }
    
            // Nurse update
            $nurse->update($validated);
    
            return redirect()->route('nurses.edit', $nurse)
                ->with('success', __('words.nurse_updated_successfully'));
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
                
        } catch (\Exception $e) {
            \Log::error('Nurse update error: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', __('words.nurse_update_error'))
                ->withInput();
        }
    }

    public function cancelPassword(Nurse $nurse)
    {
        try {
            // Passport raqami mavjudligini tekshirish
            if (!$nurse->passport_number) {
                return redirect()->route('nurses.edit', $nurse)
                    ->with('error', __('words.passport_number_not_found'));
            }
    
            // Parolni passport raqamiga o'zgartirish
            $nurse->user->password = bcrypt($nurse->passport_number);
            $nurse->user->save();
            
            return redirect()->route('nurses.edit', $nurse)
                ->with('password_cancelled', true)
                ->with('new_password', $nurse->passport_number);
                
        } catch (\Exception $e) {
            return redirect()->route('nurses.edit', $nurse)
                ->with('error', __('words.password_reset_error'));
        }
    }

    public function destroy(Nurse $nurse)
    {
        try {
            // Rasmni o'chirish
            if ($nurse->photo && Storage::disk('public')->exists($nurse->photo)) {
                Storage::disk('public')->delete($nurse->photo);
            }

            // Userni o'chirish
            if ($nurse->user) {
                $nurse->user->delete();
            }

            // Hamshirani o'chirish
            $nurse->delete();

            return back()->with('success', __('words.nurse_deleted_successfully'));

        } catch (\Exception $e) {
            Log::error('Nurse deletion error: ' . $e->getMessage());
            return back()->with('error', __('words.nurse_delete_error'));
        }
    }


    public function nurseTreatmentSheet()
    {
        $data = $this->nurseService->getNurseTreatmentSheet();
        // dd($data);
        return view('dashboard.nurses.treatment-sheet', $data);
    }

    public function saveStatus(Request $request, NurseService $nurseService)
    {
        // dd($request);
        try {
            $request->validate([
                'check_slot' => 'required|integer',
                'slots.*.status' => 'nullable|string',
                'slots.*.skip_reason' => 'nullable|string',
            ]);
            // dd($request);

            $result = $nurseService->updateSlot(
                $request->input('check_slot'),
                $request->input("slots." . $request->input('check_slot') . ".type"),
                $request->input("slots." . $request->input('check_slot') . ".status"),
                $request->input("slots." . $request->input('check_slot') . ".skip_reason")
            );

            return back()->with($result['type'], $result['message']);

        } catch (\Exception $e) {
            return back()->with('error', 'Xatolik: ' . $e->getMessage());
        }
    }
}