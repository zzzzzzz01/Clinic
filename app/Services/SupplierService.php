<?php

namespace App\Services;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SupplierService
{
    public function prepareSuppliersData($suppliers, string $locale): array
    {
        $prepared = [];
        
        foreach ($suppliers as $supplier) {
            $prepared[] = $this->prepareSupplierData($supplier, $locale);
        }
        
        return $prepared;
    }
    
    public function prepareSupplierData($supplier, string $locale): array
    {
        return [
            'id' => $supplier->id,
            'name' => $this->getValueByLocale($supplier, 'name', $locale),
            'description' => $this->getValueByLocale($supplier, 'description', $locale),
            'type' => $this->getValueByLocale($supplier, 'type', $locale),
            'email' => $supplier->email ?? '-',
            'phone' => $supplier->phone ?? '-',
            'address' => $supplier->address ?? '-',
            'is_active' => $supplier->is_active,
            'status_class' => $supplier->is_active == 1 ? 'status-active' : 'status-inactive',
            'status_text' => $supplier->is_active == 1 ? __('words.active') : __('words.inactive'),
            'status_icon' => $supplier->is_active == 1 ? 'fa-check-circle' : 'fa-times-circle'
        ];
    }
    
    /**
     * Statistika ma'lumotlarini tayyorlash
     */
    public function prepareStatsData($total, $active, $inactive): array
    {
        return [
            [
                'value' => $total,
                'label' => __('words.all'),
                'icon' => 'fas fa-truck',
                'class' => 'general'
            ],
            [
                'value' => $active,
                'label' => __('words.active'),
                'icon' => 'fas fa-check-circle',
                'class' => 'available'
            ],
            [
                'value' => $inactive,
                'label' => __('words.inactive'),
                'icon' => 'fas fa-times-circle',
                'class' => 'low'
            ]
        ];
    }
    
    private function getValueByLocale($model, string $field, string $locale): string
    {
        $fieldName = $field . '_' . $locale;
        
        if ($locale == 'uz' && isset($model->{$fieldName})) {
            return $model->{$fieldName};
        } elseif ($locale == 'ru' && isset($model->{$fieldName})) {
            return $model->{$fieldName};
        } elseif ($locale == 'en' && isset($model->{$fieldName})) {
            return $model->{$fieldName};
        }
        
        $fallbackField = $field . '_uz';
        return $model->{$fallbackField} ?? '-';
    }
    
    /**
     * Filtrlangan supplierlar va statistikani olish
     */
    public function getFilteredSuppliersWithStats(Request $request, string $locale): array
    {
        $query = Supplier::query();
        
        // Filter search
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name_uz', 'like', '%' . $request->search . '%')
                  ->orWhere('name_ru', 'like', '%' . $request->search . '%')
                  ->orWhere('name_en', 'like', '%' . $request->search . '%');
            });
        }
        
        // Filter type
        if ($request->filled('type') && $request->type != 'all') {
            $query->where('type', $request->type);
        }
        
        // Filter status
        if ($request->filled('status') && $request->status != 'all') {
            if ($request->status == 'active') {
                $query->where('is_active', 1);
            } elseif ($request->status == 'inactive') {
                $query->where('is_active', 0);
            }
        }
        
        // Pagination
        $suppliers = $query->paginate(10);
        
        // Statistikani hisoblash (filterlangan holda)
        $total = $query->count();
        $active = (clone $query)->where('is_active', 1)->count();
        $inactive = (clone $query)->where('is_active', 0)->count();
        $stats = $this->prepareStatsData($total, $active, $inactive);
        
        // Ma'lumotlarni tayyorlash
        $preparedSuppliers = $this->prepareSuppliersData($suppliers, $locale);
        
        return [
            'suppliers' => $preparedSuppliers,
            'paginator' => $suppliers,
            'stats' => $stats
        ];
    }
    
    public function clearSuppliersCache(): void
    {
        Cache::tags(['suppliers'])->flush();
    }
}