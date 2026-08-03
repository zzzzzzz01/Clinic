<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryMedicine; 
use App\Models\Medicine; 
use App\Models\MedicineStock; 
use App\Models\Supplier;
use App\Services\MedicineService;
use App\Services\MedicineInventoryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class MedicineController extends Controller
{
    protected $medicineService;
    
    public function __construct(MedicineService $medicineService)
    {
        $this->medicineService = $medicineService;
    }
    
    public function index(Request $request)
    {
        $medicines = $this->medicineService->getMedicines($request);
        $stats = $this->medicineService->getStats();
        $categories = CategoryMedicine::all();
        
        if ($request->ajax()) {
            $medicinesData = $this->medicineService->getMedicinesForAjax($medicines);
            
            return response()->json([
                'medicines' => $medicinesData,
                'pagination' => [
                    'current_page' => $medicines->currentPage(),
                    'last_page' => $medicines->lastPage(),
                    'from' => $medicines->firstItem(),
                    'to' => $medicines->lastItem(),
                    'total' => $medicines->total(),
                ]
            ]);
        }
        
        return view('dashboard.medicines.index', compact('medicines', 'categories', 'stats'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $categories = CategoryMedicine::all();

        return view('dashboard.medicines.create', compact('suppliers', 'categories'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'package_type' => 'required|string',
                'medicine_category_id' => 'required|exists:category_medicines,id',
                'strength_value' => 'required|numeric',
                'strength_unit' => 'required|string',
                'form' => 'required|string',
                'units_per_box' => 'required|integer',
                'stock_boxes' => 'nullable|integer',
                'min_stock' => 'required|integer',
                'supplier_id' => 'required|exists:suppliers,id',
                'price' => 'required|numeric',
                'description_uz' => 'nullable|string',
                'description_ru' => 'nullable|string',
                'description_en' => 'nullable|string',
            ]);

            Medicine::create($validated);

            return redirect()
                ->route('medicines.index')
                ->with('success', __('words.medicine_created_success'));

        } catch (ValidationException $e) {
            $errors = $e->errors();
            $firstError = reset($errors);
            $errorMessage = is_array($firstError) ? $firstError[0] : $firstError;
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $errorMessage);
                
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', __('words.medicine_create_error') . ': ' . $e->getMessage());
        }
    }

    public function show(Medicine $medicine)
    {
        $data = $this->medicineService->getShowData($medicine);
        
        return view('dashboard.medicines.show', $data);
    }

    public function edit(Medicine $medicine)
    {
        $categories = CategoryMedicine::all();
        $suppliers = Supplier::all();
        $medicine->load(['category', 'supplier']);
        
        return view('dashboard.medicines.edit', compact('medicine', 'categories', 'suppliers'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'medicine_category_id' => 'required|exists:category_medicines,id',
                'form' => 'nullable|string|max:100',
                'package_type' => 'nullable|string|max:100',
                'strength_value' => 'required|numeric',
                'strength_unit' => 'required|string|max:10',
                'units_per_box' => 'nullable|integer',
                'stock_boxes' => 'nullable|integer',
                'min_stock' => 'nullable|integer',
                'supplier_id' => 'nullable|exists:suppliers,id',
                'price' => 'required|numeric',
                'description_uz' => 'nullable|string',
                'description_en' => 'nullable|string',
                'description_ru' => 'nullable|string',
            ]);
            
            DB::beginTransaction();
            
            $medicine->update($validated);
            
            DB::commit();
            
            return redirect()->route('medicines.index')
                ->with('success', __('words.medicine_updated_success'));
                
        } catch (ValidationException $e) {
            $errors = $e->errors();
            $firstError = reset($errors);
            $errorMessage = is_array($firstError) ? $firstError[0] : $firstError;
            
            return back()->withErrors($errors)->withInput()->with('error', $errorMessage);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Medicine update error: ' . $e->getMessage());
            
            return back()->with('error', __('words.medicine_update_error') . ': ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Medicine $medicine)
    {
        try {
            $medicine->delete();
            
            return redirect()
                ->route('medicines.index')
                ->with('success', __('words.medicine_deleted_success'));
                
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', __('words.medicine_delete_error') . ': ' . $e->getMessage());
        }
    }


    // Medicine inventory
    public function inventory(Request $request, MedicineInventoryService $service)
    {
        return view('dashboard.medicines.inventory', $service->getInventoryData($request));
    }

    public function history(Medicine $medicine, MedicineInventoryService $service)
    {
        $histories = $service->getStockHistory($medicine);
        
        return view('dashboard.medicines.medicine-receive-history', compact('medicine', 'histories'));
    }

    public function receiveMedicine(Request $request)
    {
        // Pending dagi dorilarni olish
        $pendingStocks = MedicineStock::with(['medicine.category', 'medicine.supplier', 'user'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Dorilar ro'yxati (dialog uchun)
        $query = Medicine::with(['category', 'supplier']);
        
        // Search filter
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Category filter
        if ($request->filled('category') && $request->category != 'all') {
            $query->where('medicine_category_id', $request->category);
        }
        
        $medicines = $query->orderBy('name')->get();
        $categories = CategoryMedicine::all();
        $suppliers = Supplier::all();
        
        return view('dashboard.medicines.medicine-receive', compact('medicines', 'categories', 'suppliers', 'pendingStocks'));
    }

    /**
     * 1-chi store - Kutilmoqda holatida saqlash (medication_stock ga yoziladi)
     * Dorilarni vaqtinchalik saqlash (pending)
     */
    public function savePending(Request $request)
    {
        try {
            DB::beginTransaction();
    
            $validated = $request->validate([
                'medicine_id' => 'required|exists:medicines,id',
                'quantity_boxes' => 'required|integer|min:1',
                'pieces_per_box' => 'required|integer|min:1',
                'receive_date' => 'required|date',
            ]);
    
            $medicine = Medicine::findOrFail($validated['medicine_id']);
            $totalPieces = $validated['quantity_boxes'] * $validated['pieces_per_box'];
    
            // Medication_stock ga yozish (status = 'pending')
            $stock = MedicineStock::create([
                'medicine_id' => $validated['medicine_id'],
                'quantity_boxes' => $validated['quantity_boxes'],
                'pieces_per_box' => $validated['pieces_per_box'],
                'total_pieces' => $totalPieces,
                'receive_date' => $validated['receive_date'],
                'status' => 'pending',
                'user_id' => auth()->id(),
            ]);
    
            DB::commit();
    
            return redirect()->back()
                ->with('success', 'Dori muvaffaqiyatli qo\'shildi. (Pending holatida)');
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Medicine receive save pending error: ' . $e->getMessage());
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Xatolik yuz berdi: ' . $e->getMessage());
        }
    }

    /**
     * 2-chi store - Saqlash va yakunlash (Tasdiqlash)
     * medication_stock dagi statusni 'completed' ga o'zgartiradi
     * va medications dagi stock_boxes ga yozadi
     */
    public function saveAndComplete(Request $request)
    {
        // dd($request);
        try {
            DB::beginTransaction();

            // Validatsiya - pending dagi stock id larni tekshirish
            $validated = $request->validate([
                'stock_ids' => 'required|array|min:1',
                'stock_ids.*' => 'exists:medicine_stocks,id',
            ]);

            $pendingStocks = MedicineStock::whereIn('id', $validated['stock_ids'])
                ->where('status', 'pending')
                ->get();

            if ($pendingStocks->isEmpty()) {
                return redirect()
                    ->back()
                    ->with('error', 'Tasdiqlash uchun hech qanday dori yo\'q!');
            }

            $completedCount = 0;

            foreach ($pendingStocks as $stock) {
                $medicine = Medicine::findOrFail($stock->medicine_id);

                // 1. Medication_stock statusini 'completed' ga o'zgartirish
                $stock->update([
                    'status' => 'completed',
                ]);

                // 2. Medications dagi stock_boxes ni yangilash
                $medicine->stock_boxes = ($medicine->stock_boxes ?? 0) + $stock->quantity_boxes;
                $medicine->save();

                $completedCount++;
            }

            DB::commit();

            return redirect()
                ->route('medicine.inventory')
                ->with('success', $completedCount . ' ta dori muvaffaqiyatli qabul qilindi va omborga qo\'shildi.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Medicine save and complete error: ' . $e->getMessage());
            
            return redirect()
                ->back()
                ->with('error', 'Xatolik yuz berdi: ' . $e->getMessage());
        }
    }

    /**
     * Update - Medication_stock dagi ma'lumotni tahrirlash (faqat pending holatidagilarni)
     */
    public function updatePending(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'quantity_boxes' => 'required|integer|min:1',
                'pieces_per_box' => 'required|integer|min:1',
                'receive_date' => 'required|date',
            ]);

            $stock = MedicineStock::findOrFail($id);

            // Faqat 'pending' holatidagilarni tahrirlash mumkin
            if ($stock->status !== 'pending') {
                throw new \Exception('Faqat pending holatidagi ma\'lumotlarni tahrirlash mumkin!');
            }

            $totalPieces = $validated['quantity_boxes'] * $validated['pieces_per_box'];

            $stock->update([
                'quantity_boxes' => $validated['quantity_boxes'],
                'pieces_per_box' => $validated['pieces_per_box'],
                'total_pieces' => $totalPieces,
                'receive_date' => $validated['receive_date'],
            ]);

            DB::commit();

            return redirect()->back()
                ->with('success', 'Ma\'lumot muvaffaqiyatli yangilandi.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Medicine receive update pending error: ' . $e->getMessage());
            
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Xatolik yuz berdi: ' . $e->getMessage());
        }
    }

    /**
     * Delete - Medication_stock dan o'chirish (faqat pending holatidagilarni)
     */
    public function deletePending($id)
    {
        try {
            DB::beginTransaction();

            $stock = MedicineStock::findOrFail($id);

            // Faqat 'pending' holatidagilarni o'chirish mumkin
            if ($stock->status !== 'pending') {
                throw new \Exception('Faqat pending holatidagi ma\'lumotlarni o\'chirish mumkin!');
            }

            $stock->delete();

            DB::commit();

            return redirect()->back()
                ->with('success', 'Ma\'lumot muvaffaqiyatli o\'chirildi.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Medicine receive delete pending error: ' . $e->getMessage());
            
            return redirect()
                ->back()
                ->with('error', 'Xatolik yuz berdi: ' . $e->getMessage());
        }
    }
}