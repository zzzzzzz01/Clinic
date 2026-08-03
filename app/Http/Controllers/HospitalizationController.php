<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestStoreRequest;
use App\Models\Hospitalization;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\Test;
use App\Models\Panel;
use App\Models\Procedure;
use App\Models\Room;
use App\Models\Medicine;
use App\Models\HospitalizationStaff;
use App\Models\HospitalizationProcedure;
use App\Models\HospitalizationOrder; 
use App\Models\HospitalizationOrderItem;
use App\Models\TestResult;
use App\Models\PanelTest;
use App\Models\HospitalizationProcedureAdministration;
use App\Models\HospitalizationPrescription;
use App\Services\HospitalizationService;
use App\Services\LaboratoryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Requests\HospitalizationProcedureStoreRequest;
use App\Http\Requests\PrescriptionAdministrationRequest;
use App\Http\Requests\PrescriptionStoreRequest;

class HospitalizationController extends Controller
{
    protected $hospitalizationService;
     
    public function __construct(HospitalizationService $hospitalizationService, LaboratoryService $laboratoryService)
    {
        $this->hospitalizationService = $hospitalizationService;
        $this->laboratoryService = $laboratoryService;
    }
    
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $hospitalizations = $this->hospitalizationService->getHospitalizations($request, $user);
        $departments = $this->hospitalizationService->getDepartments();
        $stats = $this->hospitalizationService->getStats($user);

        // dd($hospitalizations->all());
        
        return view('dashboard.hospitalizations.index', compact(
            'hospitalizations',
            'departments',
            'stats'
        ));
    }

    public function show(Hospitalization $hospitalization)
    {
        $data = $this->hospitalizationService->getShowPageData($hospitalization);
        
        return view('dashboard.hospitalizations.show', $data);
    }

    public function testStore(TestStoreRequest $request, Hospitalization $hospitalization)
    {
        // dd($request);
        DB::beginTransaction();
        
        try {
            // 1️⃣ selected_tests ni arrayga aylantiramiz
            $items = json_decode($request->selected_tests, true);
            
            // Agar $items null bo'lsa yoki array bo'lmasa
            if (!is_array($items)) {
                throw new \Exception('Selected tests formati noto\'g\'ri');
            }
            
            // 2️⃣ Order yaratamiz
            $order = HospitalizationOrder::create([
                'hospitalization_id' => $request->hospitalization_id,
                'ordered_by'         => $request->ordered_by,
                'ordered_to'         => $request->hospitalization->appointment->patient->id, 
                'ordered_at'         => $request->order_date ?? now(),
                'status'             => 'pending',
                'order_type'         => $request->order_type,
                'total_price'        => collect($items)->sum('price'),
                'note'               => $request->notes,
            ]);
            
            // 3️⃣ Har bir tanlangan test / panel
            foreach ($items as $item) {
                
                // Order item yaratish
                $orderItem = HospitalizationOrderItem::create([
                    'hospitalization_order_id' => $order->id,
                    'item_type' => $item['type'] === 'test'
                        ? 'test'
                        : 'panel',
                    'item_id'  => $item['id'],
                    'quantity' => 1,
                    'price'    => $item['price'],
                    'status'   => 'pending',
                    'order_type'  => $request->order_type,
                ]);
                
                /**
                 * 4️⃣ AGAR YAKKA TEST BO'LSA
                 */
                if ($item['type'] === 'test') {
                    
                    $test = Test::find($item['id']);
                    
                    if (!$test) {
                        throw new \Exception("Test ID: {$item['id']} topilmadi");
                    }
                    
                    TestResult::create([
                        'hospitalization_order_item_id' => $orderItem->id,
                        'test_id'     => $test->id,
                        'value'       => null,
                        'unit'        => $test->unit,
                        'normal_min'  => $test->normal_min,
                        'normal_max'  => $test->normal_max,
                        'status'      => 'pending',
                        'resulted_at' => null,
                    ]);
                }
                
                /**
                 * 5️⃣ AGAR PANEL BO'LSA
                 */
                if ($item['type'] === 'testPanel') {
                    
                    $panel = PanelTest::with('tests')->find($item['id']);
                    
                    if (!$panel) {
                        throw new \Exception("Panel ID: {$item['id']} topilmadi");
                    }
                    
                    foreach ($panel->tests as $test) {
                        
                        TestResult::create([
                            'hospitalization_order_item_id' => $orderItem->id,
                            'test_id'     => $test->id,
                            'value'       => null,
                            'unit'        => $test->unit,
                            'normal_min'  => $test->normal_min,
                            'normal_max'  => $test->normal_max,
                            'status'      => 'pending',
                            'resulted_at' => null,
                        ]);
                    }
                }
            }
            
            DB::commit();
            return redirect()->back()->with('success', 'Testlar muvaffaqiyatli buyurtma qilindi');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Xatolik yuz bergan bo'lsa, logga yozamiz
            Log::error('TestStore xatosi: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Xatolik haqida foydalanuvchiga xabar beramiz
            return redirect()->back()->with('error', 'Xatolik yuz berdi: ' . $e->getMessage());
        }
    }

    public function procedureStore(HospitalizationProcedureStoreRequest $request, Hospitalization $hospitalization)
    {
        try {
            // Validation
            $validated = $request->validated();

            // staff_id ni ajratib olish (doctor_1 / nurse_3)
            [$type, $id] = explode('_', $validated['staff_id']);

            if ($type === 'doctor') {
                $staffType = Doctor::class;
            } elseif ($type === 'nurse') {
                $staffType = Nurse::class;
            } else {
                throw new \Exception('Noto‘g‘ri xodim turi', 400);
            }

            // faqat doctor yoki nurse bo‘lishini tekshiramiz
            if (!in_array($type, ['doctor', 'nurse'])) {
                throw new \Exception('Noto‘g‘ri xodim turi', 400);
            }

            // Procedure narxini olish (history uchun)
            $procedure = Procedure::findOrFail($validated['procedure_id']);

            // Saqlash
            HospitalizationProcedure::create([
                'patient_id' => $validated['patient_id'],
                'hospitalization_id' => $validated['hospitalization_id'],
                'procedure_id' => $validated['procedure_id'],
                'staff_id' => $id,
                'staff_type' => $staffType,
                'status' => 'pending',
                'price' => $procedure->price,
                'assigned_at' => now(),
                'room_id' => $validated['room_id'],
                'notes' => $validated['notes'],
            ]);

            // Qaytish
            return redirect()->back()->with('success', 'Protsedura muvaffaqiyatli biriktirildi');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
                
        } catch (\Exception $e) {
            \Log::error('Procedure store error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            return redirect()->back()
                ->with('error', 'Xatolik yuz berdi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function procedurAedministrationStore(Request $request)
    {
        // dd($request);
        try {
            // Action: save yoki cancel
            $action = $request->input('action', 'save'); 

            // Validation faqat save bo'lsa
            if ($action === 'save') {
                $validated = $request->validate([
                    'hospitalization_id' => 'required|exists:hospitalizations,id',
                    'hospitalization_procedure_id' => 'required|exists:hospitalization_procedures,id',
                    'patient_id' => 'required|exists:patients,id',
                    'administered_by' => 'required|string',
                    'administration_at' => 'nullable|date',
                    'notes' => 'nullable|string',
                ]);

                [$type, $id] = explode('_', $validated['administered_by']);

                $staffType = $type === 'doctor' ? Doctor::class : Nurse::class;

                $hpAdmin = HospitalizationProcedureAdministration::create([
                    'hospitalization_id' => $validated['hospitalization_id'],
                    'hospitalization_procedure_id' => $validated['hospitalization_procedure_id'],
                    'patient_id' => $validated['patient_id'],
                    'administered_by_type' => $staffType,
                    'administered_by_id' => $id,
                    'ordered_at' => $validated['ordered_at'] ?? now(),
                    'administration_at' => $validated['administration_at'] ?? null,
                    'status' => 'completed',
                    'notes' => $validated['notes'] ?? null,
                ]);

                // 2️⃣ Agar save bo'lsa, asosiy procedure statusini ham completed qilamiz
                $procedure = HospitalizationProcedure::find($validated['hospitalization_procedure_id']);
                if ($procedure) {
                    $procedure->update(['status' => 'completed']);
                }

                return redirect()->back()->with('success', 'Prosedura muvaffaqiyatli tugatildi!');
            }

            throw new \Exception('Noto‘g‘ri amal', 400);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
                
        } catch (\Exception $e) {
            \Log::error('Administration store error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'action' => $request->input('action'),
                'request' => $request->all()
            ]);
            
            return redirect()->back()
                ->with('error', 'Xatolik yuz berdi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function procedureAdministrationCancel(Request $request) {
        $request->validate([
            'hospitalization_procedure_id' => 'required|exists:hospitalization_procedures,id',
        ]);
    
        $procedure = HospitalizationProcedure::findOrFail(
            $request->hospitalization_procedure_id
        );
    
        $procedure->update([
            'status' => 'cancelled'
        ]);
    
        return redirect()->back()->with('success', 'Prosedura bekor qilindi!');
    }

    public function procedureUpdate(Request $request)
    {
        // dd($request);
        try {
            $procedure = HospitalizationProcedure::findOrFail(
                $request->hospitalization_procedure_id
            );

            [$type, $id] = explode('_', $request->staff_id);

            $staffType = $type === 'doctor'
                ? Doctor::class
                : Nurse::class;

            $procedureModel = Procedure::findOrFail($request->procedure_id);

            $procedure->update([
                'procedure_id' => $request->procedure_id,
                'staff_id'     => $id,
                'staff_type'   => $staffType,
                'room_id'      => $request->room_id,
                'notes'        => $request->notes,
                'price'        => $procedureModel->price,
            ]);

            return redirect()->back()
                ->with('success', 'Protsedura muvaffaqiyatli yangilandi');

        } catch (\Exception $e) {
            \Log::error('Procedure update error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return redirect()->back()
                ->with('error', 'Xatolik yuz berdi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function procedureDestroy($id)
    {
        try {
            DB::beginTransaction();
    
            // procedure ni topish
            $procedure = HospitalizationProcedure::findOrFail($id);
    
            // o‘chirish
            $procedure->delete();
    
            DB::commit();
    
            return redirect()
                ->back()
                ->with('success', 'Protsedura muvaffaqiyatli o‘chirildi');
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
    
            return redirect()
                ->back()
                ->with('error', 'Protsedura topilmadi');
    
        } catch (\Exception $e) {
            DB::rollBack();
    
            return redirect()
                ->back()
                ->with('error', 'Xatolik yuz berdi: ' . $e->getMessage());
        }
    }

    public function testPanelShow(Hospitalization $hospitalization, HospitalizationOrderItem $item)
    {
        // dd($item->item_id);
        $data = $this->hospitalizationService->makeViewData($hospitalization, $item);

        return view('dashboard.hospitalizations.test-panel.show', [
            'hospitalization' => $hospitalization,
            'item' => $item,
            'data' => $data
        ]);
    }

    public function prescriptionStore(PrescriptionStoreRequest $request, Hospitalization $hospitalization) 
    {
        // dd($request);
        try {
    
            $this->hospitalizationService
                ->storePrescription(
                    $request->validated(),
                    $hospitalization
                );
    
    
            return redirect()->back()
                ->with('success','Dori muvaffaqiyatli qo‘shildi');
    
    
        } catch (\Exception $e) {
    
            return redirect()->back()
                ->with('error',$e->getMessage())
                ->withInput();
        }
    }


    public function prescriptionAdministrationStore(PrescriptionAdministrationRequest $request)
    {
        // dd($request);
        return $this->hospitalizationService->handleExecution($request->validated());
    }

    public function roomStore(Request $request, Hospitalization $hospitalization)
    {
        try {
            $validated = $request->validate([
                'hospitalization_id' => 'required',
                'bed_id'             => 'required',
                'assigned_at'        => 'required',
            ]);

            app(HospitalizationService::class)
                ->transferRoom($hospitalization, $validated);

                return back()->with('success', 'Xona muvaffaqiyatli biriktirildi');

        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function staffStore(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'hospitalization_id' => 'required|exists:hospitalizations,id',
            'staff'              => 'required|string',
            'role'               => 'nullable|string|max:255',
        ]);

        // staff qiymati: doctor_1 yoki nurse_3
        [$type, $id] = explode('_', $request->staff);

        if ($type === 'doctor') {
            $staffType = Doctor::class;
        } elseif ($type === 'nurse') {
            $staffType = Nurse::class;
        } else {
            abort(400, 'Noto‘g‘ri xodim turi');
        }

        // 1️⃣ Shu statsional uchun oldingi faol xodimni yopamiz
        HospitalizationStaff::where('hospitalization_id', $request->hospitalization_id)
            ->where('staff_type', $staffType)
            ->whereNull('unassigned_at')
            ->update([
                'unassigned_at' => now(),
            ]);

        // 2️⃣ Yangi xodimni biriktiramiz
        HospitalizationStaff::create([
            'hospitalization_id' => $request->hospitalization_id,
            'staff_id'           => $id,
            'staff_type'         => $staffType,
            'role'               => $request->role,
            'assigned_at'        => now(),
            'unassigned_at'      => null,
        ]);

        return back()->with('success', 'Xodim muvaffaqiyatli biriktirildi');
    }

    public function laboratoryTest(Request $request)
    {
        $data = $this->laboratoryService->getFilteredTests($request);
        return view('dashboard.laboratory.index', $data);
    }

    public function laboratoryTestShow(HospitalizationOrderItem $item)
    {
        $data = $this->laboratoryService->getLaboratoryTestShowData($item);
        return view('dashboard.laboratory.show', $data);
    }


}