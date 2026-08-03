<?php
// app/Http/Controllers/FeatureController.php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Services\FeatureService;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Exception;

class FeatureController extends Controller
{
    protected FeatureService $featureService;
    
    public function __construct(FeatureService $featureService)
    {
        $this->featureService = $featureService;
    }
    
    /**
     * Asosiy sahifa - INDEX
     */
    // public function index()
    // {
    //     try {
    //         $features = Feature::paginate(10);
    //         $statistics = $this->featureService->getStatistics($features);
    //         $editFeature = null;
            
    //         // Har bir feature uchun status badge va lokalizatsiya ma'lumotlarini tayyorlash
    //         $featuresData = [];
    //         foreach ($features as $feature) {
    //             $featuresData[$feature->id] = [
    //                 'status_badge' => $this->featureService->getStatusBadgeData($feature),
    //                 'localized_name' => $this->featureService->getLocalizedName($feature),
    //                 'localized_description' => $this->featureService->getLocalizedDescription($feature)
    //             ];
    //         }
            
    //         return view('dashboard.rooms.features.index', compact(
    //             'features', 
    //             'editFeature', 
    //             'statistics',
    //             'featuresData'
    //         ));
            
    //     } catch (Exception $e) {
    //         return back()->with('error', 'Xatolik yuz berdi: ' . $e->getMessage());
    //     }
    // }

    public function index(Request $request)
    {
        // dd($request->all());
        
        $perPage = $request->get('per_page', 10);
        
        $data = $this->featureService->getfeatures($perPage);
        
        return view('dashboard.rooms.features.index', array_merge($data));
    }
    
    /**
     * Tahrirlash formasi - EDIT
     */
    public function edit(Feature $feature)
    {
        try {
            $features = Feature::paginate(10);
            $statistics = $this->featureService->getStatistics($features);
            $editFeature = $feature;
            
            $featuresData = [];
            foreach ($features as $feat) {
                $featuresData[$feat->id] = [
                    'status_badge' => $this->featureService->getStatusBadgeData($feat),
                    'localized_name' => $this->featureService->getLocalizedName($feat),
                    'localized_description' => $this->featureService->getLocalizedDescription($feat)
                ];
            }
            
            return view('dashboard.rooms.features.index', compact(
                'features', 
                'editFeature', 
                'statistics',
                'featuresData'
            ));
            
        } catch (Exception $e) {
            return redirect()->route('features.index')->with('error', __('words.error_occurred') . ': ' . $e->getMessage());
        }
    }
    
    /**
     * Yangi qulaylik qo'shish - STORE
     */
    public function store(Request $request)
    {
        try {
            // Validatsiya
            $request->validate([
                'name_uz' => 'required|string|max:255',
                'name_ru' => 'nullable|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'description_uz' => 'nullable|string',
                'description_ru' => 'nullable|string',
                'description_en' => 'nullable|string',
                'status' => 'required|in:0,1'
            ]);
            
            // Ma'lumotlarni yaratish
            $feature = Feature::create([
                'name_uz' => $request->name_uz,
                'name_ru' => $request->name_ru,
                'name_en' => $request->name_en,
                'description_uz' => $request->description_uz,
                'description_ru' => $request->description_ru,
                'description_en' => $request->description_en,
                'status' => $request->status
            ]);

            // Cache ni tozalash
            $this->featureService->clearFeaturesCache();
            
            if (!$feature) {
                throw new Exception(__('words.feature_not_created'));
            }
            
            return redirect()->route('features.index')
                ->with('success', __('words.feature_created_successfully'));
                
        } catch (QueryException $e) {
            return back()->with('error', __('words.database_error') . ': ' . $e->getMessage())->withInput();
        } catch (Exception $e) {
            return back()->with('error', __('words.error_occurred') . ': ' . $e->getMessage())->withInput();
        }
    }
    
    /**
     * Qulaylikni yangilash - UPDATE
     */
    public function update(Request $request, Feature $feature)
    {
        try {
            // Validatsiya
            $request->validate([
                'name_uz' => 'nullable|string|max:255',
                'name_ru' => 'nullable|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'description_uz' => 'nullable|string',
                'description_ru' => 'nullable|string',
                'description_en' => 'nullable|string',
                'status' => 'nullable|in:0,1'
            ]);
            
            // Ma'lumotlarni yangilash
            $updated = $feature->update([
                'name_uz' => $request->name_uz ?? $feature->name_uz,
                'name_ru' => $request->name_ru,
                'name_en' => $request->name_en,
                'description_uz' => $request->description_uz,
                'description_ru' => $request->description_ru,
                'description_en' => $request->description_en,
                'status' => $request->status ?? $feature->status
            ]);

            // Cache ni tozalash
            $this->featureService->clearFeaturesCache();
            
            if (!$updated) {
                throw new Exception(__('words.feature_not_updated'));
            }
            
            return redirect()->route('features.index')
                ->with('success', __('words.feature_updated_successfully'));
                
        } catch (QueryException $e) {
            return back()->with('error', __('words.database_error') . ': ' . $e->getMessage())->withInput();
        } catch (Exception $e) {
            return back()->with('error', __('words.error_occurred') . ': ' . $e->getMessage())->withInput();
        }
    }
    
    /**
     * Qulaylikni o'chirish - DESTROY
     */
    public function destroy(Feature $feature)
    {
        try {
            // O'chirish
            $deleted = $feature->delete();
            
            if (!$deleted) {
                throw new Exception(__('words.feature_not_deleted'));
            }
            
            // Cache ni tozalash
            $this->featureService->clearFeaturesCache();
            
            return redirect()->route('features.index')
                ->with('success', __('words.feature_deleted_successfully'));
                
        } catch (QueryException $e) {
            return back()->with('error', __('words.database_error') . ': ' . $e->getMessage());
        } catch (Exception $e) {
            return back()->with('error', __('words.error_occurred') . ': ' . $e->getMessage());
        }
    }
}