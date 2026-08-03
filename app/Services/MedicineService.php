<?php

namespace App\Services;

use App\Models\Medicine;
use App\Models\CategoryMedicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicineService
{
    /**
     * Dorilar ro'yxatini qaytarish
     */
    public function getMedicines(Request $request)
    {
        $query = Medicine::with(['category', 'supplier']);

        // Qidiruv
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Turi (form) filteri
        if ($request->filled('form') && $request->form != 'all') {
            $query->where('form', $request->form);
        }

        // Kategoriya filteri
        if ($request->filled('category') && $request->category != 'all') {
            $query->where('category_id', $request->category);
        }

        // Narx filteri
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        return $query->paginate(10);
    }

    /**
     * Statistika ma'lumotlarini qaytarish
     */
    public function getStats()
    {
        return [
            [
                'label' => __('words.total_medicines'),
                'value' => Medicine::count(),
                'icon' => 'fas fa-pills',
                'class' => 'blue',
            ],

            [
                'label' => __('words.categories'),
                'value' => CategoryMedicine::count(),
                'icon' => 'fas fa-tags',
                'class' => 'green',
            ],

            [
                'label' => __('words.avg_price'),
                'value' => number_format(Medicine::avg('price') ?? 0, 0, '', ' ') . ' $',
                'icon' => 'fas fa-money-bill-wave',
                'class' => 'yellow',
            ],

            [
                'label' => __('words.suppliers'),
                'value' => Medicine::distinct('supplier_id')->count('supplier_id'),
                'icon' => 'fas fa-truck',
                'class' => 'indigo',
            ],
        ];
    }

    /**
     * AJAX so'rov uchun JSON ma'lumotlar
     */
    public function getMedicinesForAjax($medicines)
    {
        return $medicines->map(function ($medicine) {
            return [
                'id' => $medicine->id,
                'name' => $medicine->name,
                'category_name' => $medicine->category->name ?? '-',
                'form' => $medicine->form ?? '-',
                'strength_value' => $medicine->strength_value,
                'strength_unit' => $medicine->strength_unit,
                'units_per_box' => $medicine->units_per_box,
                'supplier_name' => $medicine->supplier->name ?? '-',
                'price' => number_format($medicine->price, 0, '', ' '),
            ];
        });
    }

    /**
     * Show sahifasi uchun ma'lumotlarni tayyorlash
     */
    public function getShowData(Medicine $medicine)
    {
        // Relationlarni yuklash
        $medicine->load(['category', 'supplier']);
        
        // Stock foizini hisoblash
        $currentStock = $medicine->stock_boxes ?? 0;
        $minStock = $medicine->min_stock ?? 0;
        
        $stockPercentage = $minStock > 0 ? min(100, ($currentStock / $minStock) * 100) : 100;
        $stockClass = $stockPercentage <= 30 ? ($stockPercentage <= 10 ? 'critical' : 'low') : '';
        
        return [
            'medicine' => $medicine,
            'stockPercentage' => $stockPercentage,
            'stockClass' => $stockClass,
            'formattedPrice' => number_format($medicine->price, 0, '', ' '),
            'formattedCreatedAt' => $medicine->created_at->format('d.m.Y H:i'),
            'formattedUpdatedAt' => $medicine->updated_at->format('d.m.Y H:i'),
        ];
    }
}