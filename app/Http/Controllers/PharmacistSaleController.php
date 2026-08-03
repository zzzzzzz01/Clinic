<?php

namespace App\Http\Controllers; 

use Carbon\Carbon;
use App\Models\Medicine; 
use App\Models\MedicineUsage; 
use App\Models\MedicineUsageItem; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\PharmacistSaleService;
use Illuminate\Support\Facades\Cache;

class PharmacistSaleController extends Controller
{
    protected $saleService;
    
    public function __construct(PharmacistSaleService $saleService)
    {
        $this->saleService = $saleService;
    }

    public function sales(Request $request)
    {
        $cacheKey = 'pharmacist_sales_data_' . md5($request->fullUrl());
        
        // Cache dan olish
        $result = Cache::remember($cacheKey, 600, function () use ($request) {
            return $this->saleService->getMedicineData($request);
        });
    
        // Bugungi sotuvlarni cache dan olish (tez o'zgaradigan narsa uchun 5 minut)
        $todaySalesKey = 'pharmacist_today_sales';
        $todaySales = Cache::remember($todaySalesKey, 300, function () {
            return $this->saleService->todaySales();
        });
        
        if ($request->wantsJson()) {
            return response()->json($result);
        }
        
        return view('dashboard.pharmacist.sales', [
            'data' => $result['data'],
            'pagination' => $result['pagination'],
            'categories' => $result['categories'],
            'todaySales' => $todaySales,
        ]);
    }
    

    public function storeSale(Request $request)
    {
        try {
            DB::beginTransaction();

            $items = $request->input('items', []);

            if (empty($items)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Savat bo\'sh'
                ]);
            }

            $paymentMethod = $request->input('payment_method', 'cash');
            $userId = auth()->id();
            $totalPrice = 0;

            // Asosiy sotuvni yaratish
            $medicineUsage = MedicineUsage::create([
                'total_price'    => 0,
                'payment_method' => $paymentMethod,
                'user_id'        => $userId,
            ]);

            foreach ($items as $item) {

                $medicine = Medicine::lockForUpdate()->find($item['medicine_id']);

                if (!$medicine) {
                    throw new \Exception("Dori topilmadi.");
                }

                // Sotilayotgan miqdorni donaga o'tkazish
                $soldUnits = $item['unit'] === 'box'
                    ? ($item['quantity'] * $medicine->units_per_box)
                    : $item['quantity'];

                // Qoldiqni tekshirish
                if ($medicine->stock_units < $soldUnits) {
                    throw new \Exception(
                        "{$medicine->name} uchun yetarli qoldiq yo'q. Qoldiq: {$medicine->stock_units} dona"
                    );
                }

                // Narx hisoblash
                $unitPrice = $item['price'];
                $itemTotalPrice = $unitPrice * $item['quantity'];

                $totalPrice += $itemTotalPrice;

                // Sotuv elementini saqlash
                MedicineUsageItem::create([
                    'medicine_usage_id' => $medicineUsage->id,
                    'medicine_id'       => $medicine->id,
                    'unit'              => $item['unit'], // piece yoki box
                    'quantity'          => $item['quantity'],
                    'price'             => $unitPrice,
                    'total_price'       => $itemTotalPrice,
                ]);

                // Omborni yangilash
                $medicine->stock_units -= $soldUnits;

                // Qutilarni qayta hisoblash
                $medicine->stock_boxes = intdiv(
                    $medicine->stock_units,
                    $medicine->units_per_box
                );

                $medicine->save();
            }

            // Umumiy narxni yangilash
            $medicineUsage->update([
                'total_price' => $totalPrice
            ]);

            DB::commit();

            Cache::flush(); // yoki faqat kerakli key larni

            return redirect()->back()->with(
                'success',
                'Sotish muvaffaqiyatli amalga oshirildi.'
            );

        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Sale error: ' . $e->getMessage());

            return redirect()->back()->with(
                'error',
                'Xatolik yuz berdi: ' . $e->getMessage()
            );
        }
    }

    public function searchMedicines(Request $request)
    {
        $search = $request->input('search');
        
        $query = Medicine::with(['category', 'stocks']);
        
        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }
        
        $medicines = $query->limit(20)->get();
        
        $data = $medicines->map(function ($medicine) {
            $lastStock = $medicine->stocks->last();
            $status = $this->saleService->getStatus($medicine);
            
            return [
                'medicine_id' => $medicine->id,
                'name' => $medicine->name,
                'generic_name' => $medicine->strength_value 
                    ? $medicine->strength_value . ' ' . $medicine->strength_unit 
                    : '',
                'form' => $medicine->form ?? 'N/A',
                'stock_boxes' => $medicine->stock_boxes,
                'units_per_box' => $medicine->units_per_box,
                'price' => $medicine->price,
                'status' => $status,
            ];
        });
        
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }


    public function salesReport(Request $request)
    {
        // Service dan hamma ma'lumot keladi, daySalesList ham
        $data = $this->saleService->getSalesReport($request);
        
        return view('dashboard.pharmacist.report', $data);
    }
}
