<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Test;
use App\Models\Panel;
use Illuminate\Http\Request;
use App\Services\TestService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class TestController extends Controller
{
    protected $testService;

    public function __construct(TestService $testService)
    {
        $this->testService = $testService;
    }

    public function index(Request $request)
    {
        $tests = $this->testService->getFilteredTests($request);
        $stats = $this->testService->getStats();
        $departments = Department::all();
        
        return view('dashboard.laboratory.tests.index', compact('tests', 'stats', 'departments'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'        => 'required|string|max:255',
                'code'        => 'nullable',
                'unit'        => 'nullable|string|max:50',
                'normal_min'  => 'nullable|numeric',
                'normal_max'  => 'nullable|numeric|gte:normal_min',
                'price'       => 'required',
                'duration'    => 'required|integer|min:1',
                'is_active'   => 'nullable|boolean',
            ]);
    
            Test::create([
                'name'        => $validated['name'],
                'code'        => $validated['code'] ?? null,
                'unit'        => $validated['unit'] ?? null,
                'normal_min'  => $validated['normal_min'] ?? null,
                'normal_max'  => $validated['normal_max'] ?? null,
                'price'       => $validated['price'] ?? null,
                'duration'    => $validated['duration'] ?? false,
                'is_active'   => $validated['is_active'] ?? false,
            ]);
    
            return redirect()
                ->back()
                ->with('success', __('words.test_created_successfully'));
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', __('words.test_validation_error'));
    
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', __('words.test_create_error', ['error' => $e->getMessage()]))
                ->withInput();
        }
    }
    
    public function update(Request $request, Test $test)
    {
        try {
            $validated = $request->validate([
                'code' => 'required|string|max:255|unique:tests,code,' . $test->id,
                'name' => 'required|string|max:255',
                'unit' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'normal_min' => 'required|numeric',
                'normal_max' => 'required|numeric',
                'duration' => 'required|integer|min:1',
                'is_active' => 'required|boolean'
            ]);
    
            DB::beginTransaction();
    
            $test->update([
                'code' => $validated['code'],
                'name' => $validated['name'],
                'unit' => $validated['unit'],
                'price' => $validated['price'],
                'normal_min' => $validated['normal_min'],
                'normal_max' => $validated['normal_max'],
                'duration'   => $validated['duration'] ?? false,
                'is_active' => $validated['is_active'] ?? false,
            ]);
    
            DB::commit();
    
            return redirect()->route('tests.index')->with('success', __('words.test_updated_successfully'));
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Test update error: ' . $e->getMessage());
            
            return redirect()->back()->withErrors(['error' => __('words.test_update_error', ['error' => $e->getMessage()])]);
        }
    }
    
    public function destroy(Test $test)
    {
        try {
            DB::beginTransaction();
    
            $testName = $test->name;
            $test->delete();
    
            DB::commit();
    
            return redirect()->route('tests.index')->with('success', __('words.test_deleted_successfully', ['name' => $testName]));
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Test delete error: ' . $e->getMessage());
            
            return redirect()->back()->withErrors(['error' => __('words.test_delete_error', ['error' => $e->getMessage()])]);
        }
    }

    public function panels(Request $request)
    {
        $departments = Department::all();
        
        $query = Panel::with('tests', 'department');
        
        // Qidiruv
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name_uz', 'like', '%' . $search . '%')
                ->orWhere('name_ru', 'like', '%' . $search . '%')
                ->orWhere('name_en', 'like', '%' . $search . '%')
                ->orWhere('description_uz', 'like', '%' . $search . '%')
                ->orWhere('description_ru', 'like', '%' . $search . '%')
                ->orWhere('description_en', 'like', '%' . $search . '%');
            });
        }
        
        // Holat bo'yicha filtr
        if ($request->filled('status') && $request->status != 'all') {
            if ($request->status == 'active') {
                $query->where('status', 1);
            } elseif ($request->status == 'inactive') {
                $query->where('status', 0);
            }
        }
        
        // Saralash
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price':
                    $query->orderBy('price', 'asc');
                    break;
                case 'time':
                    $query->orderBy('time', 'asc');
                    break;
                default:
                    $query->orderBy('name_uz', 'asc');
            }
        } else {
            $query->orderBy('name_uz', 'asc');
        }
        
        // Bo'lim bo'yicha filtr
        if ($request->filled('department') && $request->department != 'all') {
            $query->where('department_id', $request->department);
        }
        
        $testPanels = $query->paginate(10);
        
        // Filter parametrlarini paginationda saqlash
        $testPanels->appends($request->all());
        
        return view('dashboard.laboratory.panels.index', compact('departments', 'testPanels'));
    }

    public function panelStore(Request $request)
    {
        try {
            $validated = $request->validate([
                'name_uz' => 'required|string|max:255',
                'name_ru' => 'required|string|max:255',
                'name_en' => 'required|string|max:255',
                'code' => 'required|string|max:100|unique:panels,code',
                'price' => 'nullable|numeric|min:0',
                'time' => 'required|integer|min:1',
                'description_uz' => 'nullable|string',
                'description_ru' => 'nullable|string',
                'description_en' => 'nullable|string',
                'department_id' => 'nullable|exists:departments,id',
            ]);

            $panel = Panel::create([
                'name_uz' => $validated['name_uz'],
                'name_ru' => $validated['name_ru'],
                'name_en' => $validated['name_en'],
                'code' => $validated['code'],
                'price' => $validated['price'] ?? 0,
                'description_uz' => $validated['description_uz'] ?? null,
                'description_ru' => $validated['description_ru'] ?? null,
                'description_en' => $validated['description_en'] ?? null,
                'department_id' => $validated['department_id'] ?? null,
                'time' => $validated['time'],
                'status' => 0,
            ]);

            \Log::info('Panel created successfully', [
                'panel_id' => $panel->id,
                'panel_name' => $panel->name,
                'user_id' => auth()->id()
            ]);

            return redirect()->back()->with('success', 'Panel muvaffaqiyatli yaratildi');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            \Log::error('Panel store error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Xatolik yuz berdi')->withInput();
        }
    }

    public function panelDestroy(Panel $panel)
    {
        try {
            DB::beginTransaction();

            $panelName = $panel->name;
            $panel->delete();

            DB::commit();

            return redirect()->route('tests.panels')->with('success', '"' . $panelName . '" test paneli muvaffaqiyatli o\'chirildi!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Test delete error: ' . $e->getMessage());
            
            return redirect()->back()->withErrors(['error' => 'Test paneli o\'chirishda xatolik yuz berdi: ' . $e->getMessage()]);
        }
    }

    public function panelEdit(Panel $panel)
    {
        // Servis orqali ma'lumotlarni tayyorlash
        $data = $this->testService->getPanelEditData($panel);
        
        return view('dashboard.laboratory.panels.edit', $data);
    }

    public function panelUpdate(Request $request, Panel $panel)
    {
        try {
            DB::beginTransaction();

            // Servis orqali panelni yangilash
            $result = $this->testService->updatePanel($request, $panel);

            DB::commit();

            return redirect()
                ->route('test-panels.edit', $panel)
                ->with('success', $result['message']);

        } catch (ValidationException $e) {
            DB::rollBack();
            
            return back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', __('words.validation_error'));

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollBack();
            
            \Log::error('DB xatosi: ' . $e->getMessage(), [
                'panel_id' => $panel->id,
            ]);
        
            return back()
                ->withInput()
                ->with('error', __('words.database_error'));

        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Umumiy xatolik: ' . $e->getMessage(), [
                'panel_id' => $panel->id,
            ]);
        
            return back()
                ->withInput()
                ->with('error', __('words.unexpected_error', ['error' => $e->getMessage()]));
        }
    }
}