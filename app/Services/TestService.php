<?php

namespace App\Services;

use App\Models\Panel;
use App\Models\Test;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class TestService
{
    /**
     * Get filtered tests with pagination
     */
    public function getFilteredTests(Request $request): LengthAwarePaginator 
    {
        $query = Test::query();

        // Qidiruv filteri
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // Holat filteri
        if ($request->filled('status') && $request->status != 'all') {
            $isActive = $request->status === 'available' ? 1 : 0;
            $query->where('is_active', $isActive);
        }

        // Narx oralig'i filteri
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // Saralash
        $sort = $request->get('sort', 'name_asc');
        switch ($sort) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'code_asc':
                $query->orderBy('code', 'asc');
                break;
            default:
                $query->orderBy('name', 'asc');
                break;
        }

        return $query->paginate(12);
    }

    /**
     * Get test statistics
     */
    public function getStats(): array
    {
        return [
            'total' => Test::count(),
            'active' => Test::where('is_active', 1)->count(),
            'inactive' => Test::where('is_active', 0)->count(),
        ];
    }

    /**
     * Panel edit uchun ma'lumotlarni tayyorlash
     */
    public function getPanelEditData(Panel $panel): array
    {
        return [
            'panel' => $panel,
            'departments' => Department::all(),
            'allTests' => Test::all(),
            'panelTests' => $panel->tests,
            'selectedTests' => $panel->tests->pluck('id')->toArray(),
        ];
    }

    /**
     * Panelni yangilash
     */
    public function updatePanel(Request $request, Panel $panel): array
    {
        // Validatsiya qilingan ma'lumotlar
        $validated = $request->validate([
            'selected_tests' => 'nullable|string',
            'name_uz' => 'nullable|string|max:255',
            'name_ru' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'code' => 'required|string|max:50',
            'department_id' => 'required|exists:departments,id',
            'description_uz' => 'nullable|string',
            'description_ru' => 'nullable|string',
            'description_en' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'time' => 'required|integer|min:1',
            'status' => 'required|in:0,1',
        ]);

        // Panel asosiy ma'lumotlarini yangilash
        $panel->update([
            'name_uz' => $request->name_uz,
            'name_ru' => $request->name_ru,
            'name_en' => $request->name_en,
            'code' => $request->code,
            'department_id' => $request->department_id,
            'description_uz' => $request->description_uz,
            'description_ru' => $request->description_ru,
            'description_en' => $request->description_en,
            'price' => $request->price,
            'time' => $request->time,
            'status' => $request->status,
        ]);

        // Testlarni yangilash
        $testChanges = $this->syncPanelTests($panel, $request->input('selected_tests', ''));

        // Xabar tayyorlash
        $message = $this->getUpdateMessage($testChanges);

        return [
            'success' => true,
            'message' => $message,
            'testChanges' => $testChanges
        ];
    }

    /**
     * Panel testlarini sinxronlash
     */
    public function syncPanelTests(Panel $panel, string $selectedTests): array
    {
        // Yangi test ID larini tayyorlash
        $newTestIds = collect(explode(',', $selectedTests))
            ->filter()
            ->map(fn($id) => (int)$id)
            ->unique()
            ->values()
            ->toArray();

        // Eski test ID larini olish
        $oldTestIds = $panel->tests()->pluck('tests.id')->toArray();

        // Qo'shilgan va o'chirilgan testlarni hisoblash
        $addedTests = array_diff($newTestIds, $oldTestIds);
        $removedTests = array_diff($oldTestIds, $newTestIds);

        // Sinxronlash
        $panel->tests()->sync($newTestIds);

        // Log yozish
        $this->logTestChanges($panel, $addedTests, $removedTests);

        return [
            'added' => $addedTests,
            'removed' => $removedTests,
            'addedCount' => count($addedTests),
            'removedCount' => count($removedTests),
            'totalCount' => count($newTestIds)
        ];
    }

    /**
     * Log yozish
     */
    private function logTestChanges(Panel $panel, array $addedTests, array $removedTests): void
    {
        if (!empty($removedTests)) {
            Log::info("Panel ID: {$panel->id} dan testlar olib tashlandi", [
                'panel_name' => $panel->name,
                'removed_test_ids' => $removedTests,
            ]);
        }

        if (!empty($addedTests)) {
            Log::info("Panel ID: {$panel->id} ga testlar qo'shildi", [
                'panel_name' => $panel->name,
                'added_test_ids' => $addedTests,
            ]);
        }
    }

    /**
     * 3 xil tilda xabar olish
     */
    public function getUpdateMessage(array $testChanges): string
    {
        $addedCount = $testChanges['addedCount'];
        $removedCount = $testChanges['removedCount'];
        $locale = app()->getLocale();

        if ($addedCount > 0 && $removedCount > 0) {
            return match($locale) {
                'uz' => "Panelga {$addedCount} ta test qo'shildi va {$removedCount} ta test olib tashlandi",
                'ru' => "В панель добавлено {$addedCount} тестов и удалено {$removedCount} тестов",
                'en' => "{$addedCount} tests added and {$removedCount} tests removed from the panel",
                default => "{$addedCount} tests added and {$removedCount} tests removed from the panel"
            };
        } elseif ($addedCount > 0) {
            return match($locale) {
                'uz' => "Panelga {$addedCount} ta test muvaffaqiyatli qo'shildi",
                'ru' => "В панель успешно добавлено {$addedCount} тестов",
                'en' => "{$addedCount} tests successfully added to the panel",
                default => "{$addedCount} tests successfully added to the panel"
            };
        } elseif ($removedCount > 0) {
            return match($locale) {
                'uz' => "Paneldan {$removedCount} ta test muvaffaqiyatli olib tashlandi",
                'ru' => "Из панели успешно удалено {$removedCount} тестов",
                'en' => "{$removedCount} tests successfully removed from the panel",
                default => "{$removedCount} tests successfully removed from the panel"
            };
        } else {
            return match($locale) {
                'uz' => "Panel ma'lumotlari muvaffaqiyatli yangilandi",
                'ru' => "Данные панели успешно обновлены",
                'en' => "Panel data successfully updated",
                default => "Panel data successfully updated"
            };
        }
    }
}