<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Feature;
use App\Models\Department;
use App\Models\RoomType;
use App\Models\BedRoom;
use App\Models\Hospitalization;
use App\Models\HospitalizationRoom;
use App\Services\RoomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class RoomController extends Controller
{
    protected $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    public function index(Request $request)  // <-- Request $request ni qo'shing
    {
        $page = request()->get('page', 1);

        // Rooms query with filters
        $query = Room::query();
        
        // Qidiruv (search) - xona raqami bo'yicha
        if ($request->filled('search')) {
            $query->where('number', 'like', "%{$request->search}%");
        }
        
        // Xona holati - 4 ta status: available, empty, full, maintenance
        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        
        // Bo'lim
        if ($request->filled('department') && $request->department != 'all') {
            $query->where('department_id', $request->department);
        }
        
        // Qavat
        if ($request->filled('floor') && $request->floor != 'all') {
            $query->where('floor', $request->floor);
        }

        // Rooms pagination cache
        $cacheKey = "rooms_page_{$page}_" . md5($request->fullUrl());
        
        $rooms = Cache::tags(['rooms'])->remember($cacheKey, 600, function () use ($query) {
            return $query->paginate(12);
        });

        // Departments cache
        $departments = Cache::tags(['departments'])->remember('departments_all', 3600, function () {
            return Department::all();
        });

        // Hospitalizations cache
        $hospitalizations = Cache::tags(['hospitalizations'])->remember('hospitalizations_waiting_for_bed', 120, function () {
            return Hospitalization::where('status', 'waiting_for_bed')
                ->with(['appointment.patient.user', 'appointment.doctor.user', 'department'])
                ->get()
                ->map(function ($h) {
                    $patient = $h->appointment?->patient?->user;
                    $doctor = $h->appointment?->doctor?->user;
    
                    return [
                        'id' => $h->id,
                        'patient_id' => $patient?->id,
                        'patient_name' => $patient
                            ? trim($patient->last_name.' '.$patient->name.' '.$patient->middle_name)
                            : "Noma'lum",
                        'patient_first_name' => $patient?->name ?? '',
                        'patient_last_name' => $patient?->last_name ?? '',
                        'patient_middle_name' => $patient?->middle_name ?? '',
                        'patient_phone' => $patient?->phone ?? 'Telefon mavjud emas',
                        'doctor_name' => $doctor
                            ? $doctor->last_name.' '.mb_substr($doctor->name,0,1).'.'
                            : 'Shifokor belgilanmagan',
                        'department_name' => $h->department?->name ?? "Bo'lim belgilanmagan",
                        'priority' => $h->priority ?? 'Normal',
                        'waiting_since' => $h->created_at->diffForHumans(),
                        'created_at' => $h->created_at->format('Y-m-d H:i'),
                    ];
                })
                ->values() // <-- BU QO'SHING
                ->toArray(); // <-- YOKI BU QO'SHING
        });

        return view('dashboard.rooms.index', compact('rooms', 'departments', 'hospitalizations'));
    }

    public function create() 
    {
        $features = Feature::all();
        $departments = Department::all();
        $roomTypes = RoomType::all();

        return view('dashboard.rooms.create', compact('features', 'departments', 'roomTypes'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'number'        => 'required|string|max:10',
                'room_type_id'  => 'required|exists:room_types,id',
                'floor'         => 'required|string|max:50',
                'department_id' => 'required|exists:departments,id',
                'capacity'      => 'nullable|integer|min:1',
                'price'         => 'required|numeric|min:0',
                'description'   => 'nullable|string',
                'features'      => 'nullable|array',
                'features.*'    => 'exists:features,id',
            ]);

            DB::beginTransaction();

            $room = Room::create([
                'number'        => $validated['number'],
                'room_type_id'  => $validated['room_type_id'],
                'floor'         => $validated['floor'],
                'department_id' => $validated['department_id'],
                'capacity'      => $validated['capacity'] ?? null,
                'price'         => $validated['price'],
                'description'   => $validated['description'] ?? null,
                'status'        => 'available',
            ]);

            if (!empty($validated['capacity']) && $validated['capacity'] > 0) {
                $bedsData = [];
                for ($i = 1; $i <= $validated['capacity']; $i++) {
                    $bedsData[] = [
                        'room_id'    => $room->id,
                        'bed_number'     => $i,
                        'status'     => 'available',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
                DB::table('bed_rooms')->insert($bedsData);
            }

            if ($request->has('features') && !empty($validated['features'])) {
                $room->features()->attach($validated['features']);
            }

            Cache::tags(['rooms'])->flush();

            DB::commit();

            return redirect()
                ->route('rooms.index')
                ->with('success', 'Xona muvaffaqiyatli yaratildi!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Xona yaratishda xatolik: ' . $e->getMessage());
            
            return redirect()
                ->back()
                ->with('error', 'Xona yaratishda xatolik yuz berdi: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Room $room)
    {
        return view('dashboard.rooms.show', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:10',
            'room_type_id' => 'required|exists:room_types,id',
            'department_id' => 'required|exists:departments,id',
            'floor' => 'required|integer|min:1|max:6',
            'capacity' => 'required|integer|min:1|max:10',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:empty,available,occupied,maintenance,full',
            'description' => 'nullable|string',
            'features' => 'array',
            'features.*' => 'exists:features,id'
        ]);

        $room->update($validated);

        if ($request->has('features')) {
            $room->features()->sync($request->features);
        } else {
            $room->features()->detach();
        }

        // cache ni tozalash
        Cache::tags(['rooms'])->flush();

        return redirect()->route('room.edit', $room->id)
            ->with('success', 'Xona muvaffaqiyatli yangilandi!');
    }

    public function edit(Room $room)
    {
        $roomTypes = RoomType::all();
        $departments = Department::all();
        $features = Feature::all();
        
        return view('dashboard.rooms.edit', compact('room', 'roomTypes', 'departments', 'features'));
    }

    public function assignPatient(Request $request, $roomId)
    {
        // dd($request);
        try {
            // Xonani topamiz
            $room = Room::findOrFail($roomId);
            // dd($room);
            
            $validated = $request->validate([
                'hospitalization_id' => 'required|exists:hospitalizations,id',
                'bed_id'             => 'required|exists:bed_rooms,id',
                'admission_date'     => 'required|date',
            ]);
    
            // Tanlangan krovat xonaga tegishli ekanligini tekshiramiz
            $bed = BedRoom::where('id', $validated['bed_id'])
                        ->where('room_id', $roomId)
                        ->first();
    
            if (!$bed) {
                return response()->json([
                    'success' => false,
                    'message' => 'Krovat xonaga tegishli emas'
                ], 422);
            }
    
            // Agar krovat band bo'lsa, xatolik qaytaramiz
            if ($bed->status === 'occupied') {
                return response()->json([
                    'success' => false,
                    'message' => 'Tanlangan o\'rin band qilingan'
                ], 422);
            }
    
            // 1️⃣ Eski active hospitalization_room ni topamiz
            $oldRoom = HospitalizationRoom::where('hospitalization_id', $validated['hospitalization_id'])
                ->whereNull('unassigned_at')
                ->latest('assigned_at')
                ->first();
    
            if ($oldRoom) {
                $oldRoom->update([
                    'unassigned_at' => now(),
                ]);
    
                $oldBed = BedRoom::find($oldRoom->bed_id);
                if ($oldBed) {
                    $oldBed->update(['status' => 'available']);
    
                    // Eski xona statusini yangilaymiz
                    $this->updateRoomStatus($oldBed->room_id);
                }
            }
    
            // 2️⃣ Yangi hospitalization_room yaratamiz
            $hospitalizationRoom = HospitalizationRoom::create([
                'hospitalization_id' => $validated['hospitalization_id'],
                'bed_id'             => $validated['bed_id'],
                'assigned_at'        => $validated['admission_date'],
                'status'             => 'under_treatment',
            ]);
    
            // Hospitalization statusini yangilaymiz
            $hospitalization = Hospitalization::find($validated['hospitalization_id']);
            $hospitalization->update([
                'status' => 'under_treatment'
            ]);
    
            // 3️⃣ Yangi krovatni band qilamiz
            $bed->update(['status' => 'occupied']);
    
            // Yangi xona statusini yangilaymiz
            $this->updateRoomStatus($roomId);
    
            return response()->json([
                'success' => true,
                'message' => 'Bemor muvaffaqiyatli joylashtirildi',
                'data' => [
                    'room_id' => $roomId,
                    'bed_id' => $bed->id,
                    'hospitalization_id' => $hospitalization->id
                ]
            ]);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validatsiya xatoligi',
                'errors' => $e->errors()
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Xona topilmadi'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Xatolik yuz berdi: ' . $e->getMessage()
            ], 500);
        }
    }

    private function updateRoomStatus($roomId)
    {
        $room = Room::with('roomBeds')->find($roomId);

        if (!$room) return;

        $totalBeds = $room->roomBeds->count();
        $occupiedBeds = $room->roomBeds->where('status', 'occupied')->count();

        if ($totalBeds > 0 && $totalBeds == $occupiedBeds) {
            $room->update(['status' => 'full']);
        } else {
            $room->update(['status' => 'available']);
        }
    }

    public function dischargePatient(Request $request, $roomId)
    {
        try {
            // Validatsiya
            $validated = $request->validate([
                'hospitalization_id' => 'required|exists:hospitalizations,id',
                'bed_id' => 'required|exists:bed_rooms,id',
                'discharge_date' => 'required|date',
                'discharge_notes' => 'nullable|string'
            ]);

            // HospitalizationRoom ni topish
            $hospitalizationRoom = HospitalizationRoom::where('hospitalization_id', $validated['hospitalization_id'])
                ->where('bed_id', $validated['bed_id'])
                ->whereNull('unassigned_at')
                ->first();

            if (!$hospitalizationRoom) {
                return response()->json([
                    'success' => false,
                    'message' => 'Aktiv hospitalization topilmadi'
                ], 404);
            }

            // Bo'shatish vaqtini qo'yish
            $hospitalizationRoom->update([
                'unassigned_at' => $validated['discharge_date'],
                'discharge_notes' => $validated['discharge_notes'] ?? null
            ]);

            // Krovatni bo'sh qilish
            $bed = BedRoom::find($validated['bed_id']);
            if ($bed) {
                $bed->update(['status' => 'available']);
            }

            // Xona statusini yangilash
            $this->updateRoomStatus($roomId);

            // Hospitalization statusini yangilash
            $hospitalization = Hospitalization::find($validated['hospitalization_id']);
            $hospitalization->update([
                'status' => 'discharged'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Bemor muvaffaqiyatli bo\'shatildi',
                'data' => [
                    'room_id' => $roomId,
                    'bed_id' => $bed->id,
                    'hospitalization_id' => $hospitalization->id,
                    'room_status' => $this->getRoomStatus($roomId)
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validatsiya xatoligi',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Xatolik yuz berdi: ' . $e->getMessage()
            ], 500);
        }
    }

    public function completeMaintenance(Request $request, Room $room)
    {
        // dd($request);
        try {
            $request->validate([
                'completion_date' => 'required|date',
                'notes' => 'nullable|string'
            ]);
    
            // Barcha bedlarni tekshirish
            $totalBeds = $room->roomBeds()->count();
            $occupiedBeds = $room->roomBeds()->where('status', 'occupied')->count();
            
            // Statusni aniqlash
            if ($occupiedBeds > 0) {
                // Agar kamida bitta bed band bo'lsa - available
                $newStatus = 'available';
            } else {
                // Agar hamma bed bo'sh bo'lsa - empty
                $newStatus = 'empty';
            }
    
            // Ta'mirni tamomlash
            $room->update([
                'status' => $newStatus,
                'maintenance_end' => $request->completion_date,
                'maintenance_notes' => $request->notes,
                'maintenance_completed_by' => auth()->id()
            ]);
    
            // =============== MUHIM: CACHE NI TOZALASH ===============
            $this->clearRoomCache();
            // ======================================================
    
            return response()->json([
                'success' => true,
                'message' => 'Xona ta\'miri muvaffaqiyatli tamomlandi',
                'room_status' => $newStatus,
                'total_beds' => $totalBeds,
                'occupied_beds' => $occupiedBeds
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Xatolik yuz berdi: ' . $e->getMessage()
            ], 500);
        }
    }

    private function clearRoomCache()
    {
        // Barcha cache larni tozalash (agar loyihada boshqa cache lar bo'lmasa)
        Cache::flush();
        
        // Yoki prefix bilan tozalash
        $redis = Redis::connection();
        $keys = $redis->keys('*rooms_page_*');
        foreach ($keys as $key) {
            $redis->del($key);
        }
    }
}