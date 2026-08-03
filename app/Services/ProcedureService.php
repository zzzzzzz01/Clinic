<?php

namespace App\Services;

use App\Models\Procedure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProcedureService
{
    /**
     * Protsedura ma'lumotlarini tayyorlash
     */
    public function prepareProcedureData($procedure, string $locale): array
    {
        return [
            'id' => $procedure->id,
            'name' => $this->getValueByLocale($procedure, 'name', $locale),
            'description' => $this->getValueByLocale($procedure, 'description', $locale),
            'category' => $procedure->category ?? '-',
            'price' => $procedure->price ?? 0,
            'duration' => $procedure->duration ?? 0,
            'is_active' => $procedure->is_active,
            'status_class' => $procedure->is_active == 1 ? 'available' : 'unavailable',
            'status_text' => $procedure->is_active == 1 ? __('words.active') : __('words.inactive'),
            'status_icon' => $procedure->is_active == 1 ? 'fa-check-circle' : 'fa-times-circle'
        ];
    }
    
    /**
     * Protseduralar ma'lumotlarini tayyorlash
     */
    public function prepareProceduresData($procedures, string $locale): array
    {
        $prepared = [];
        
        foreach ($procedures as $procedure) {
            $prepared[] = $this->prepareProcedureData($procedure, $locale);
        }
        
        return $prepared;
    }
    
    /**
     * Statistika ma'lumotlarini tayyorlash
     */
    public function prepareStatsData($total, $active, $inactive): array
    {
        return [
            [
                'value' => $total,
                'label' => __('words.total'),
                'icon' => 'fas fa-procedures',
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
    
    /**
     * Locale bo'yicha qiymat olish
     */
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
     * Filtrlangan protseduralar va statistikani olish
     */
    public function getFilteredProceduresWithStats(Request $request, string $locale): array
    {
        $query = Procedure::query();
        
        // Qidiruv
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name_uz', 'like', '%' . $search . '%')
                  ->orWhere('name_ru', 'like', '%' . $search . '%')
                  ->orWhere('name_en', 'like', '%' . $search . '%')
                  ->orWhere('category', 'like', '%' . $search . '%');
            });
        }
        
        // Kategoriya bo'yicha filtr
        if ($request->filled('category') && $request->category != 'all') {
            $query->where('category', $request->category);
        }
        
        // Holat bo'yicha filtr
        if ($request->filled('status') && $request->status != 'all') {
            if ($request->status == 'active') {
                $query->where('is_active', 1);
            } elseif ($request->status == 'inactive') {
                $query->where('is_active', 0);
            }
        }
        
        // Narx oralig'i bo'yicha filtr
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }
        
        // Saralash
        $sort = $request->get('sort', 'name_asc');
        switch ($sort) {
            case 'name_asc': $query->orderBy('name_uz', 'asc'); break;
            case 'name_desc': $query->orderBy('name_uz', 'desc'); break;
            case 'price_asc': $query->orderBy('price', 'asc'); break;
            case 'price_desc': $query->orderBy('price', 'desc'); break;
            case 'duration_asc': $query->orderBy('duration', 'asc'); break;
            case 'duration_desc': $query->orderBy('duration', 'desc'); break;
            default: $query->orderBy('name_uz', 'asc');
        }
        
        // Pagination
        $procedures = $query->paginate(15);
        
        // Statistikani hisoblash (filterlangan holda)
        $total = $query->count();
        $active = (clone $query)->where('is_active', 1)->count();
        $inactive = (clone $query)->where('is_active', 0)->count();
        $stats = $this->prepareStatsData($total, $active, $inactive);
        
        // Kategoriyalarni olish (filter uchun)
        $categories = Cache::remember('procedure_categories', 3600, function () {
            return Procedure::select('category')
                ->whereNotNull('category')
                ->distinct()
                ->pluck('category');
        });
        
        return [
            'procedures' => $procedures,
            'stats' => $stats,
            'categories' => $categories
        ];
    }
    
    /**
     * Bitta protsedurani olish
     */
    public function getProcedure($id)
    {
        return Procedure::findOrFail($id);
    }
    
    /**
     * Cache ni tozalash
     */
    public function clearCache(): void
    {
        Cache::forget('procedure_categories');
    }
}