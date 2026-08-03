<?php

namespace App\Services;

use App\Models\Medicine;
use App\Models\MedicineStock;
use App\Models\CategoryMedicine;
use Illuminate\Http\Request;

class MedicineInventoryService
{
    public function getInventoryData(Request $request)
    {
        // 1. QUERY BUILDING
        $query = Medicine::with(['category', 'supplier']);
        
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('category') && $request->category != 'all') {
            $query->where('medicine_category_id', $request->category);
        }
        
        if ($request->filled('stock_status') && $request->stock_status != 'all') {
            if ($request->stock_status == 'low') {
                $query->whereRaw('stock_boxes <= min_stock')->where('stock_boxes', '>', 0);
            } elseif ($request->stock_status == 'out') {
                $query->where('stock_boxes', '<=', 0);
            }
        }
        
        $medicines = $query->paginate(15);
        
        // 2. CALCULATE STATISTICS
        $totalMedicines = Medicine::count();
        $inStockCount = Medicine::where('stock_boxes', '>', 0)->count();
        $lowStockCount = Medicine::whereRaw('stock_boxes <= min_stock')->where('stock_boxes', '>', 0)->count();
        $outOfStockCount = Medicine::where('stock_boxes', '<=', 0)->count();
        
        // 3. GET CATEGORIES
        $categories = CategoryMedicine::all();
        
        // 4. PREPARE TABLE DATA WITH STATUS
        $tableData = $medicines->map(function($medicine, $index) use ($medicines) {
            $status = $this->getStatus($medicine);
            
            return [
                'rowNumber' => $medicines->firstItem() + $index,
                'name' => $medicine->name,
                'strength' => $medicine->strength_value ? $medicine->strength_value . ' ' . $medicine->strength_unit : null,
                'category' => mb_strimwidth($medicine->category->name ?? '-', 0, 20, '...'),
                'supplier' => $medicine->supplier->name ?? '-',
                'stockBoxes' => number_format($medicine->stock_boxes),
                'form' => $medicine->form ?? 'dona',
                'statusBg' => $status['bg'],
                'statusColor' => $status['color'],
                'statusText' => $status['text'],
                'id' => $medicine->id,
                'dropdownId' => 'dropdown-' . $index
            ];
        });
        
        return [
            'medicines' => $medicines,
            'categories' => $categories,
            'totalMedicines' => $totalMedicines,
            'inStockCount' => $inStockCount,
            'lowStockCount' => $lowStockCount,
            'outOfStockCount' => $outOfStockCount,
            'tableData' => $tableData,
            'filterParams' => $this->getFilterParams($request)
        ];
    }

    // STATUS - BIRTA FUNKSIYA
    private function getStatus($medicine)
    {
        if ($medicine->stock_boxes <= 0) {
            return [
                'bg' => '#ffebee',
                'color' => '#d32f2f',
                'text' => __('words.out_of_stock')
            ];
        }
        
        if ($medicine->stock_boxes <= $medicine->min_stock) {
            return [
                'bg' => '#fff3e0',
                'color' => '#f57c00',
                'text' => __('words.low_stock')
            ];
        }
        
        return [
            'bg' => '#e8f5e9',
            'color' => '#388e3c',
            'text' => __('words.in_stock')
        ];
    }

    public function getStats()
    {
        return [
            'totalMedicines' => Medicine::count(),
            'inStockCount' => Medicine::where('stock_boxes', '>', 0)->count(),
            'lowStockCount' => Medicine::whereRaw('stock_boxes <= min_stock')
                ->where('stock_boxes', '>', 0)
                ->count(),
            'outOfStockCount' => Medicine::where('stock_boxes', '<=', 0)->count()
        ];
    }

    private function getFilterParams(Request $request)
    {
        return [
            'hasSearch' => $request->filled('search'),
            'search' => $request->search,
            'hasCategory' => $request->filled('category') && $request->category != 'all',
            'category' => $request->category,
            'hasStockStatus' => $request->filled('stock_status') && $request->stock_status != 'all',
            'stockStatus' => $request->stock_status
        ];
    }

    public function getStockHistory($medicine)
    {
        return MedicineStock::where('medicine_id', $medicine->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    }
}