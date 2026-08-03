<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Department;
use App\Services\SupplierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SupplierController extends Controller
{
    protected $supplierService;
    
    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }
    
    public function index(Request $request)
    {
        $locale = app()->getLocale();
        $cacheKey = "suppliers_index_{$locale}_" . md5(http_build_query($request->all()));
        
        $cachedData = Cache::tags(['suppliers'])->remember($cacheKey, 3600, function () use ($request, $locale) {
            return $this->supplierService->getFilteredSuppliersWithStats($request, $locale);
        });

        $departments = Department::all();
        
        return view('dashboard.suppliers.index', [
            'suppliers' => $cachedData['suppliers'],
            'paginator' => $cachedData['paginator'],
            'stats' => $cachedData['stats'],
            'departments' => $departments,
        ]);
    }

    public function create()
    {
        return view('dashboard.suppliers.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                // Nomlari (3 til)
                'name_uz' => 'required|string|max:255',
                'name_ru' => 'required|string|max:255',
                'name_en' => 'required|string|max:255',
                
                // Tavsiflari (3 til)
                'description_uz' => 'nullable|string',
                'description_ru' => 'nullable|string',
                'description_en' => 'nullable|string',
                
                // Aloqa ma'lumotlari
                'contact_person' => 'nullable|string|max:50',
                'type_uz' => 'nullable|string|max:50',
                'type_ru' => 'nullable|string|max:50',
                'type_en' => 'nullable|string|max:50',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:500',
                'is_active' => 'nullable|boolean',
            ]);
            // dd($validated);
            
            DB::beginTransaction();
            
            $supplier = Supplier::create($validated);
            
            DB::commit();
            $this->supplierService->clearSuppliersCache();
            
            return redirect()->route('suppliers.index')
                ->with('success', __('words.supplier_created_success'));
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Supplier store error: ' . $e->getMessage());
            
            return back()->with('error', __('words.supplier_create_error'))->withInput();
        }
    }

    public function edit(Supplier $supplier)
    {
        return view('dashboard.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        try {
            $validated = $request->validate([
                'name_uz' => 'required|string|max:255',
                'name_ru' => 'required|string|max:255',
                'name_en' => 'required|string|max:255',
                'type_uz' => 'nullable|string|max:50',
                'type_ru' => 'nullable|string|max:50',
                'type_en' => 'nullable|string|max:50',
                'description_uz' => 'nullable|string',
                'description_ru' => 'nullable|string',
                'description_en' => 'nullable|string',
                'email' => 'nullable|email|max:255',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string|max:500',
                'is_active' => 'nullable|boolean',
            ]);
            
            DB::beginTransaction();
            
            $supplier->update($validated);
            
            DB::commit();
            $this->supplierService->clearSuppliersCache();
            
            return back()
                ->with('success', __('words.supplier_updated_successfully'));
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Supplier update error: ' . $e->getMessage());
            
            return back()->with('error', __('words.supplier_updated_error'));
        }
    }

    public function show(Supplier $supplier)
    {
        return view('dashboard.suppliers.show', compact('supplier'));
    }

    public function destroy(Supplier $supplier)
    {
        try {
            $supplier->delete();

            $this->supplierService->clearSuppliersCache();
            
            return redirect()->route('suppliers.index')
                ->with('success', __('words.supplier_deleted_successfully'));
                
        } catch (\Exception $e) {
            Log::error('Supplier destroy error: ' . $e->getMessage());
            
            return back()->with('error', __('words.supplier_delete_error'));
        }
    }
    
}