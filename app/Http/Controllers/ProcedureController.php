<?php

namespace App\Http\Controllers;

use App\Models\Procedure;
use App\Services\ProcedureService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProcedureController extends Controller
{
    protected $procedureService;
    
    public function __construct(ProcedureService $procedureService)
    {
        $this->procedureService = $procedureService;
    }
    
    public function index(Request $request)
    {
        $locale = app()->getLocale();
        $data = $this->procedureService->getFilteredProceduresWithStats($request, $locale);
        
        return view('dashboard.procedures.index', [
            'procedures' => $data['procedures'],
            'stats' => $data['stats'],
            'categories' => $data['categories']
        ]);
    }
    
    public function show($procedure)
    {
        $procedure = $this->procedureService->getProcedure($procedure);
        return view('dashboard.procedures.show', compact('procedure'));
    }

    public function create() 
    {
        return view('dashboard.procedures.create');
    }
    
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name_uz' => 'required|string|max:255',
                'name_ru' => 'nullable|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'category' => 'required|string|max:100',
                'price' => 'required|numeric|min:0',
                'duration' => 'required|integer|min:1',
                'description_uz' => 'nullable|string',
                'description_ru' => 'nullable|string',
                'description_en' => 'nullable|string',
                'is_active' => 'boolean',
            ]);
            
            $procedure = Procedure::create([
                'name_uz' => $validated['name_uz'],
                'name_ru' => $validated['name_ru'] ?? $validated['name_uz'],
                'name_en' => $validated['name_en'] ?? $validated['name_uz'],
                'category' => $validated['category'],
                'price' => $validated['price'],
                'duration' => $validated['duration'],
                'description_uz' => $validated['description_uz'] ?? null,
                'description_ru' => $validated['description_ru'] ?? $validated['description_uz'],
                'description_en' => $validated['description_en'] ?? $validated['description_uz'],
                'is_active' => $validated['is_active'] ?? true,
            ]);
            
            $this->procedureService->clearCache();
            
            Log::info('Procedure created', ['procedure_id' => $procedure->id]);
            
            return redirect()->route('procedures.index')
                ->with('success', __('words.procedure_created_successfully'));
            
        } catch (\Exception $e) {
            Log::error('Procedure store error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', __('words.procedure_store_error', ['error' => $e->getMessage()]))
                ->withInput();
        }
    }

    public function edit(Procedure $procedure)
    {
        return view('dashboard.procedures.edit', compact('procedure'));
    }
    
    public function update(Request $request, $id)
    {
        try {
            $procedure = Procedure::findOrFail($id);

            $validated = $request->validate([
                'name_uz' => 'nullable|string|max:255',
                'name_ru' => 'nullable|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'category' => 'nullable|string|max:100',
                'price' => 'nullable|numeric|min:0',
                'duration' => 'nullable|integer|min:1',
                'description_uz' => 'nullable|string',
                'description_ru' => 'nullable|string',
                'description_en' => 'nullable|string',
                'is_active' => 'boolean',
            ]);

            $procedure->fill($validated);

            if ($procedure->isDirty()) {
                $procedure->save();
                $this->procedureService->clearCache();

                return redirect()
                    ->route('procedures.index')
                    ->with('success', __('words.procedure_updated_successfully'));
            }

            return redirect()
                ->route('procedures.index')
                ->with('info', __('words.procedure_no_changes'));

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', __('words.procedure_update_error', ['error' => $e->getMessage()]));
        }
    }
    
    public function destroy($id)
    {
        try {
            $procedure = Procedure::findOrFail($id);
            $procedure->delete();
            
            $this->procedureService->clearCache();
            
            Log::info('Procedure deleted', ['procedure_id' => $id]);
            
            return redirect()->route('procedures.index')
                ->with('success', __('words.procedure_deleted_successfully'));
            
        } catch (\Exception $e) {
            Log::error('Procedure delete error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', __('words.procedure_delete_error', ['error' => $e->getMessage()]));
        }
    }
}