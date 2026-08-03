<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Department;
use App\Models\DepartmentDoctor;
use App\Services\DepartmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DepartmentController extends Controller
{
    protected DepartmentService $departmentService;
    
    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }
    
    public function index(Request $request)
    {
        $data = $this->departmentService->getDepartments($request);
        
        return view('dashboard.departments.index', [
            'departments' => $data['departments'],
            'doctors' => $data['doctors'],
            'stats' => $data['stats'],
            'departmentData' => $data['departmentData']
        ]);
    }
    
    public function getStaff($id)
    {
        return response()->json($this->departmentService->getDepartmentStaff($id));
    }
    
    public function departmentRooms($id)
    {
        $data = $this->departmentService->getDepartmentRoomsData($id);
        
        return view('dashboard.departments.rooms', [
            'department' => $data['department'],
            'stats' => $data['stats'],
            'rooms' => $data['rooms'],
            'roomsJson' => $data['rooms_json'],
        ]);
    }

    public function create()
    {
        $doctors = Doctor::all();
        return view('dashboard.departments.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        // dd($request);
        try {
            $validated = $request->validate([
                'name_uz' => 'required|string|max:255',
                'name_ru' => 'required|string|max:255',
                'name_en' => 'required|string|max:255',
                'head_doctor_id' => 'nullable|exists:doctors,id',
                'floor' => 'required|integer|min:1|max:4',
                'description_uz' => 'nullable|string',
                'description_ru' => 'nullable|string',
                'description_en' => 'nullable|string',
                'status' => 'required|boolean',
                'slug' => 'nullable|string|max:255|unique:departments,slug',
            ]);

            if ($request->hasFile('photo')) {
                $name = time() . '_' . $request->file('photo')->getClientOriginalName();
                $path = $request->file('photo')->storeAs('imageDepartment', $name, 'public');
            }

            $slug = $request->slug ?? Str::slug($request->name_en);
    
            // Department yaratish
            $department = Department::create([
                'name_uz' => $validated['name_uz'],
                'name_ru' => $validated['name_ru'],
                'name_en' => $validated['name_en'],
                'floor' => $validated['floor'],
                'description_uz' => $validated['description_uz'] ?? null,
                'description_ru' => $validated['description_ru'] ?? null,
                'description_en' => $validated['description_en'] ?? null,
                'status' => $validated['status'],
                'photo' => $path,
                'slug' => $slug,
            ]);
    
            // Agar head_doctor tanlangan bo'lsa, department_doctor jadvaliga qo'shish
            if (!empty($validated['head_doctor_id'])) {
                DepartmentDoctor::create([
                    'department_id' => $department->id,
                    'doctor_id' => $validated['head_doctor_id'],
                    'is_head' => true,
                ]);
            }

            // Cache ni tozalash
            $this->departmentService->clearDepartmentsCache();
    
            return redirect()->route('department.index')
                ->with('success', __('words.department_created_successfully'));
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', __('words.error_occurred') . ': ' . $e->getMessage())
                ->withInput();
        }
    }
    
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name_uz' => 'required|string|max:255',
                'name_ru' => 'required|string|max:255',
                'name_en' => 'required|string|max:255',
                'floor' => 'required|integer|min:1|max:4',
                'head_doctor_id' => 'nullable|exists:doctors,id',
                'status' => 'required|boolean',
                'description_uz' => 'nullable|string',
                'description_ru' => 'nullable|string',
                'description_en' => 'nullable|string'
            ]);
            
            $this->departmentService->updateDepartment($id, $validated);
            
            return redirect()->route('department.index')
                ->with('success', 'Bo\'lim muvaffaqiyatli yangilandi!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Xatolik: ' . $e->getMessage());
        }
    }
    
    public function destroy($id)
    {
        try {
            $this->departmentService->deleteDepartment($id);
            
            return redirect()->route('department.index')
                ->with('success', 'Bo\'lim muvaffaqiyatli o\'chirildi!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Xatolik: ' . $e->getMessage());
        }
    }
}