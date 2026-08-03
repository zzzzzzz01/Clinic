<?php
// app/Services/FeatureService.php

namespace App\Services;

use App\Models\Feature;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;

class FeatureService
{
    public function getfeatures(int $perPage = 10): array
    {
        $currentLocale = App::getLocale();
        $cacheKey = $this->generateCacheKey($perPage, $currentLocale);
        
        return Cache::tags(['features'])->remember($cacheKey, 300, function () use ($perPage, $currentLocale) {
            $query = Feature::query(); 
            
            $features = $query->paginate($perPage)->withQueryString();
            $formatfeatures = $this->formatFeaturesForList($features, $currentLocale);
            
            return [
                'features' => $features,
                'formattedFeatures' => $formatfeatures
            ];
        });
    }

    /**
     * Cache kalitini yaratish
     */
    private function generateCacheKey(int $perPage, string $locale): string
    {
        return 'features_index_' . md5(json_encode([
            'page' => request()->get('page', 1),
            'per_page' => $perPage,
            'locale' => $locale,
        ]));
    }

    /**
     * Doktorlarni LIST uchun formatlash (index sahifasi)
     */
    public function formatFeaturesForList($features, string $locale = null): array
    {
        $locale = $locale ?? App::getLocale();
        $formattedFeatures = [];
        
        foreach ($features as $feature) {

            $statusConfig = $this->statusConfig($feature->status);

            $formattedFeatures[] = (object)[
                'id' => $feature->id,

                'name_uz' => $feature->name_uz,
                'name_ru' => $feature->name_ru,
                'name_en' => $feature->name_en,

                'description_uz' => $feature->description_uz,
                'description_ru' => $feature->description_ru,
                'description_en' => $feature->description_en,

                // localized
                'name' => $this->getFeatureLocalizedName($feature, $locale),
                'description' => $this->getFeatureLocalizedDescription($feature, $locale),

                'created_at' => $feature->created_at,
                'status' => $feature->status,

                'status_text' => $statusConfig['text'],
                'status_text_color' => $statusConfig['text_color'],
                'status_bg_color' => $statusConfig['bg_color'],
                'status_icon' => $statusConfig['icon'],
            ];
        }
        
        return $formattedFeatures;
    }

    private function getFeatureLocalizedName(Feature $feature, string $locale): string
    {
        
        return match($locale) {
            'ru' => $feature->name_ru ?? $feature->name_uz ?? '-',
            'en' => $feature->name_en ?? $feature->name_uz ?? '-',
            default => $feature->name_uz ?? '-',
        };
    }

    private function getFeatureLocalizedDescription(Feature $feature, string $locale): string
    {
        
        return match($locale) {
            'ru' => $feature->description_ru ?? $feature->description_uz ?? '-',
            'en' => $feature->description_en ?? $feature->description_uz ?? '-',
            default => $feature->description_uz ?? '-',
        };
    }


    /**
     * Feature status badge ma'lumotlarini tayyorlash
     */
    public function statusConfig(string $status): array
    {
        if ($status == 1) {
            return [
                'text' => __('words.active'),
                'color' => '#27ae60',
                'bg_color' => 'rgba(46, 204, 113, 0.2)',
                'text_color' => '#27ae60',
                'icon' => 'fas fa-circle-check'
            ];
        }
        
        return [
            'text' => __('words.inactive'),
            'color' => '#dc3545',
            'bg_color' => '#FFCBCB',
            'text_color' => '#dc3545',
            'icon' => 'fas fa-circle-xmark'
        ];
    }
    
    /**
     * Statistika ma'lumotlarini tayyorlash
     */
    public function getStatistics(LengthAwarePaginator $features): array
    {
        $allFeatures = Feature::all();
        
        return [
            'total' => $features->total(),
            'active' => $allFeatures->where('status', 1)->count(),
            'inactive' => $allFeatures->where('status', 0)->count()
        ];
    }
    
    /**
     * Joriy tilga mos nomni olish
     */
    public function getLocalizedName(Feature $feature): string
    {
        $locale = app()->getLocale();
        
        return match($locale) {
            'ru' => $feature->name_ru ?? $feature->name_uz,
            'en' => $feature->name_en ?? $feature->name_uz,
            default => $feature->name_uz
        };
    }
    
    /**
     * Joriy tilga mos tavsifni olish
     */
    public function getLocalizedDescription(Feature $feature): ?string
    {
        $locale = app()->getLocale();
        
        return match($locale) {
            'ru' => $feature->description_ru ?? $feature->description_uz,
            'en' => $feature->description_en ?? $feature->description_uz,
            default => $feature->description_uz
        };
    }

    /**
     * Cacheni tozalash
     */
    public function clearFeaturesCache(): void
    {
        Cache::tags(['features'])->flush();
    }
}