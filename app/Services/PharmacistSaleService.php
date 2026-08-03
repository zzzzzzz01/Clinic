<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Medicine;
use App\Models\MedicineUsage;
use App\Models\CategoryMedicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PharmacistSaleService
{
    public function getMedicineData(Request $request)
    {
        // Parametrlarni olish
        $search = $request->input('search');
        $categoryId = $request->input('category_id');
        $perPage = $request->input('per_page', 15);
        
        // Asosiy so'rov - Medicine modeli bilan
        $query = Medicine::with(['category', 'stocks']); // Faqat sotuvda mavjud bo'lganlar
        
        // Qidiruv bo'yicha filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('barcode', 'LIKE', "%{$search}%")
                  ->orWhere('generic_name', 'LIKE', "%{$search}%");
            });
        }
        
        // Kategoriya bo'yicha filter
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        
        // Natijalarni olish (paginated)
        $medicines = $query->paginate($perPage);
        
        // Qo'shimcha ma'lumotlar: kategoriyalar ro'yxati (filter uchun)
        $categories = CategoryMedicine::select(
            'id',
            'name_uz',
            'name_ru',
            'name_en'
        )->get();
        
        // Formatlangan ma'lumotlarni qaytarish
        return [
            'success' => true,
            'data' => $medicines->map(function ($medicine) {
                // Eng oxirgi stock ma'lumotini olish
                $lastStock = $medicine->stocks->last();
                $status = $this->getStatus($medicine);
                
                return [
                    'medicine_id' => $medicine->id,
                    'name' => $medicine->name,
                    'barcode' => $medicine->barcode,
                    'generic_name' => $medicine->strength_value 
                        ? $medicine->strength_value . ' ' . $medicine->strength_unit 
                        : '',
                    'form' => $medicine->form ?? 'N/A',
                    'category_id' => $medicine->category_id,
                    'stock_boxes' => $medicine->stock_boxes, // Asosiy qoldiq
                    'units_per_box' => $medicine->units_per_box,
                    'price' => $medicine->price,
                    'selling_price' => $medicine->selling_price,
                    'expiry_date' => $lastStock->expiry_date ?? null,
                    'batch_no' => $lastStock->batch_no ?? null,
                    'stock_id' => $lastStock->id ?? null,
                    'status' => $status,
                ];
            }),
            'pagination' => [
                'total' => $medicines->total(),
                'per_page' => $medicines->perPage(),
                'current_page' => $medicines->currentPage(),
                'last_page' => $medicines->lastPage(),
            ],
            'categories' => $categories,
        ];
    }

    public function getStatus($medicine)
    {
        $stock = $medicine->stock_boxes ?? 0;
        $unit = $medicine->stock_units ?? 0;
        $minStock = $medicine->min_stock ?? 5;
        
        if ($stock <= 0) {
            return [
                'text' => $unit . ' d',
                'text_color' => '#dc3545',
                'bg_color' => '#f8d7da',
                'icon' => 'fas fa-times-circle'
            ];
        } elseif ($stock <= $minStock) {
            return [
                'text' => $stock . ' q ' . $unit . ' d',
                'text_color' => '#f39c12',
                'bg_color' => '#fef9e7',
                'icon' => 'fas fa-exclamation-triangle'
            ];
        } else {
            return [
                'text' => $stock . ' q ' . $unit . ' d',
                'text_color' => '#27ae60',
                'bg_color' => '#d1ede7',
                'icon' => 'fas fa-check-circle'
            ];
        }
    }

    public function todaySales()
    {
        $usages = MedicineUsage::with('items.medicine')
            ->whereDate('created_at', today())
            ->get();
        
        $data = [];
        foreach ($usages as $usage) {
            $items = [];
            foreach ($usage->items as $item) {
                $items[] = [
                    'medicine_name' => $item->medicine->name,
                    'medicine_strength' => $item->medicine->strength_value . ' ' . $item->medicine->strength_unit ,
                    'quantity' => $item->quantity,
                    'unit' => $item->unit,
                    'price' => $item->price,
                    'total_price' => $item->total_price,
                    'unit' => $this->unitType($item),
                ];
            }
            
            $data[] = [
                'id' => $usage->id,
                'total_price' => $usage->total_price,
                'created_at' => $usage->created_at,
                'items' => $items,
                'payment_method' => $this->payMethod($usage),
            ];
        }
        
        return $data;
    }

    public function unitType($item)
    {
        return match ($item->unit) {
            'box' => __('words.box'),
            'piece' => __('words.piece'),
            default => $item->unit,
        };
    }

    public function payMethod($usage)
    {
        return match ($usage->payment_method) {
            'cash' => 'Naqt pul',
            'card' => 'Plastik karta',
            'transfer' => 'Pul o\'tkazma',
            default => $usage->payment_method,
        };
    }
    
    /**
     * Report Sahifasi 
     */
    public function getSingleMedicine($medicineId)
    {
        $medicine = Medicine::with(['category', 'stocks'])
            ->where('id', $medicineId)
            ->where('stock_boxes', '>', 0)
            ->first();
            
        if (!$medicine) {
            return [
                'success' => false,
                'message' => 'Dori topilmadi yoki mavjud emas'
            ];
        }
        
        $lastStock = $medicine->stocks->last();
        
        return [
            'success' => true,
            'data' => [
                'medicine_id' => $medicine->id,
                'name' => $medicine->name,
                'barcode' => $medicine->barcode,
                'generic_name' => $medicine->generic_name,
                'category' => $medicine->category->name ?? 'N/A',
                'category_id' => $medicine->category_id,
                'stock_boxes' => $medicine->stock_boxes,
                'price' => $medicine->price,
                'selling_price' => $medicine->selling_price,
                'expiry_date' => $lastStock->expiry_date ?? null,
                'batch_no' => $lastStock->batch_no ?? null,
                'description' => $medicine->description,
                'stocks' => $medicine->stocks->map(function ($stock) {
                    return [
                        'id' => $stock->id,
                        'batch_no' => $stock->batch_no,
                        'expiry_date' => $stock->expiry_date,
                        'quantity' => $stock->quantity,
                    ];
                }),
            ]
        ];
    }

    public function clearCache()
    {
        Cache::flush(); 
    }


    /**
     * Asosiy hisobot ma'lumotlarini olish
     */
    public function getSalesReport($request)
    {
        $filterType = $request->input('filter_type', 'day');
        $filterValue = $request->input('filter_value', date('Y-m-d'));
        $paymentMethod = $request->input('payment_method', 'all');
        // dd($paymentMethod);

        // Filtr bo'yicha ma'lumotlarni olish
        if ($filterType == 'day') {
            $filteredSales = $this->getDaySales($filterValue, $paymentMethod);
        } else {
            $filteredSales = $this->getMonthSales($filterValue, $paymentMethod);
        }

        // Statistikalar
        $stats = $this->getStatistics($filteredSales, $filterType);

        // Barcha sotuvlar (statistika uchun)
        $allSales = $this->getAllSales();
        $topMedicine = $this->getTopMedicine($allSales);

        // 🔥 YANGI: daySalesList ni tayyorlash
        $daySalesList = $this->prepareDaySalesList($filteredSales, $filterType);

        return [
            'filteredSales' => $filteredSales,
            'filterType' => $filterType,
            'filterValue' => $filterValue,
            'paymentMethod' => $paymentMethod,
            'totalSales' => $stats['totalSales'],
            'totalRevenue' => $stats['totalRevenue'],
            'totalItems' => $stats['totalItems'],
            'totalCustomers' => $stats['totalCustomers'],
            'allTotalSales' => count($allSales),
            'allTotalRevenue' => array_sum(array_column($allSales, 'total_price')),
            'topMedicine' => $topMedicine,
            'monthOptions' => $this->getMonthOptions(),
            'daySalesList' => $daySalesList, // 🔥 YANGI
        ];
    }

    /**
     * 🔥 YANGI: Kunlik sotuvlar ro'yxatini tayyorlash
     */
    private function prepareDaySalesList($filteredSales, $filterType)
    {
        $daySalesList = [];
        
        if ($filterType == 'month') {
            // Oylik view da har bir kun uchun
            foreach ($filteredSales as $dayData) {
                if (isset($dayData['date']) && isset($dayData['items'])) {
                    $daySalesList[$dayData['date']] = $dayData['items'];
                }
            }
        } else {
            // Kunlik view da
            foreach ($filteredSales as $sale) {
                if (isset($sale['created_at'])) {
                    $day = substr($sale['created_at'], 0, 10);
                    if (!isset($daySalesList[$day])) {
                        $daySalesList[$day] = [];
                    }
                    $daySalesList[$day][] = $sale;
                }
            }
        }
        
        return $daySalesList;
    }

    /**
     * Kunlik sotuvlar
     */
    public function getDaySales($filterValue, $paymentMethod)
    {
        $query = MedicineUsage::with(['items.medicine'])
            ->where('user_id', auth()->id())
            ->whereDate('given_at', $filterValue)
            ->orderBy('given_at', 'desc');

        $usages = $query->get(); 
        $sales = $this->formatSales($usages);

        // To'lov turi bo'yicha filter
        if ($paymentMethod != 'all') {
            $sales = $this->filterByPayment($sales, $paymentMethod);
        }

        return $sales;
    }

    /**
     * Oylik sotuvlar (kunlar bo'yicha guruhlangan)
     */
    public function getMonthSales($filterValue, $paymentMethod)
    {
        $year = substr($filterValue, 0, 4);
        $month = substr($filterValue, 5, 2);

        $query = MedicineUsage::with(['items.medicine'])
            ->where('user_id', auth()->id())
            ->whereYear('given_at', $year)
            ->whereMonth('given_at', $month)
            ->orderBy('given_at', 'asc');

        $usages = $query->get();

        // Kunlar bo'yicha guruhlash
        $groupedByDay = $usages->groupBy(function($usage) {
            return Carbon::parse($usage->given_at)->format('Y.m.d');
        });

        $dayStats = [];
        foreach ($groupedByDay as $day => $dayUsages) {
            $daySales = $this->formatSales($dayUsages);
            
            // To'lov turi bo'yicha filter
            if ($paymentMethod != 'all') {
                $daySales = $this->filterByPayment($daySales, $paymentMethod);
            }

            $dayStats[] = [
                'date' => $day,
                'count' => count($daySales),
                'total' => array_sum(array_column($daySales, 'total_price')),
                'items' => $daySales
            ];
        }

        ksort($dayStats);
        return $dayStats;
    }

    /**
     * Sotuv ma'lumotlarini formatlash
     */
    private function formatSales($usages)
    {
        return $usages->map(function($usage) {
            return [
                'id' => $usage->id,
                'created_at' => Carbon::parse($usage->given_at)->format('Y.m.d H:i:s'),
                'items' => $usage->items->map(function($item) {
                    return [
                        'medicine_name' => $item->medicine->name ?? 'Noma\'lum',
                        'medicine_strength' => $item->medicine->strength_value ?? '',
                        'quantity' => $item->quantity,
                        'unit' => $item->unit, // Asl qiymat
                        'unit_label' => $this->unitTypeMon($item->unit), // Tarjima qilingan qiymat
                        'price' => $item->price
                    ];
                })->toArray(),
                'payment_method' => $usage->payment_method, // 🔥 O'ZGARMAGAN HOLDA qoldiring
                'payment_method_label' => $this->paymentMethod($usage->payment_method), // 🔥 YANGI: label uchun
                'total_price' => $usage->total_price
            ];
        })->toArray();
    }

    private function paymentMethod($paymentMethod)
    {
        return match ($paymentMethod) {
            'cash' => __('words.pharmacist.sales.cash'),
            'card' => __('words.pharmacist.sales.card'),
            'transfer' => __('words.pharmacist.sales.transfer'),
            default => $paymentMethod,
        };
    }

    private function unitTypeMon($unit)
    {
        return match ($unit) {
            'box' => __('words.box'),
            'piece' => __('words.piece'),
            default => $unit,
        };
    }

    /**
     * To'lov turi bo'yicha filter
     */
    private function filterByPayment($sales, $paymentMethod)
    {
        return array_values(array_filter($sales, function($sale) use ($paymentMethod) {
            return $sale['payment_method'] == $paymentMethod;
        })); 
    }

    /**
     * Statistikalar
     */
    private function getStatistics($filteredSales, $filterType)
    {
        if ($filterType == 'day') {
            $totalSales = count($filteredSales);
            $totalRevenue = array_sum(array_column($filteredSales, 'total_price'));
            $totalItems = $this->calcTotalItems($filteredSales);
            $totalCustomers = count($filteredSales);
        } else {
            $totalSales = count($filteredSales);
            $totalRevenue = array_sum(array_column($filteredSales, 'total'));
            $totalItems = 0;
            $totalCustomers = 0;
            foreach ($filteredSales as $dayData) {
                foreach ($dayData['items'] as $sale) {
                    foreach ($sale['items'] as $item) {
                        $totalItems += $item['quantity'];
                    }
                    $totalCustomers++;
                }
            }
        }

        return [
            'totalSales' => $totalSales,
            'totalRevenue' => $totalRevenue,
            'totalItems' => $totalItems,
            'totalCustomers' => $totalCustomers,
        ];
    }

    /**
     * Jami mahsulotlar sonini hisoblash
     */
    private function calcTotalItems($sales)
    {
        $total = 0;
        foreach ($sales as $sale) {
            foreach ($sale['items'] as $item) {
                $total += $item['quantity'];
            }
        }
        return $total;
    }

    /**
     * Barcha sotuvlar
     */
    private function getAllSales()
    {
        return MedicineUsage::with(['items.medicine'])
            ->where('user_id', auth()->id())
            ->get()
            ->map(function($usage) {
                return [
                    'id' => $usage->id,
                    'created_at' => Carbon::parse($usage->given_at)->format('Y.m.d H:i:s'),
                    'items' => $usage->items->map(function($item) {
                        return [
                            'medicine_name' => $item->medicine->name ?? 'Noma\'lum',
                            'medicine_strength' => $item->medicine->strength ?? '',
                            'quantity' => $item->quantity,
                            'unit' => $item->unit,
                            'price' => $item->price
                        ];
                    })->toArray(),
                    'payment_method' => $usage->payment_method,
                    'total_price' => $usage->total_price
                ];
            })->toArray();
    }

    /**
     * Eng ko'p sotilgan dori
     */
    private function getTopMedicine($allSales)
    {
        $medicineCount = [];
        foreach ($allSales as $sale) {
            foreach ($sale['items'] as $item) {
                $key = $item['medicine_name'] . ' ' . $item['medicine_strength'];
                if (!isset($medicineCount[$key])) {
                    $medicineCount[$key] = 0;
                }
                $medicineCount[$key] += $item['quantity'];
            }
        }
        arsort($medicineCount);
        return array_key_first($medicineCount) ?? 'Noma\'lum';
    }

    /**
     * Oy variantlari
     */
    private function getMonthOptions()
    {
        $options = [];
        for ($m = 1; $m <= 12; $m++) {
            $options[] = date('Y-m', strtotime(date('Y') . "-{$m}-01"));
        }
        return $options;
    }

    /**
     * Kunlik dialog uchun ma'lumotlar
     */
    public function getDayDetail($date)
    {
        $usages = MedicineUsage::with(['items.medicine'])
            ->where('user_id', auth()->id())
            ->whereDate('given_at', $date)
            ->orderBy('given_at', 'asc')
            ->get();

        return $this->formatSales($usages);
    }
}