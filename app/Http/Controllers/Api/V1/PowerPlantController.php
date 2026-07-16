<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\PowerPlant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PowerPlantController extends Controller
{
    /**
     * GET /api/v1/power-plants
     * คืนรายการโรงไฟฟ้าทั้งหมด พร้อมกำลังผลิตล่าสุดจาก energy_readings
     */
    public function index(): JsonResponse
    {
        $powerPlants = PowerPlant::with('latestReading')->get();

        return response()->json([
            'message' => 'เรียกดูรายการโรงไฟฟ้าสำเร็จ',
            'data'    => $powerPlants->map(
                fn (PowerPlant $plant) => $this->plantSummary($plant)),
        ]);
    }

    /**
     * GET /api/v1/power-plants/{id}
     * รายละเอียดโรงไฟฟ้า + ค่าไฟฟ้าล่าสุด + พลังงานวันนี้ + กราฟ 20 ค่าล่าสุด
     */
    public function show($id): JsonResponse
    {
        $powerPlant = PowerPlant::with('latestReading')->find($id);

        if (!$powerPlant) {
            return response()->json([
                'message' => 'ไม่พบโรงไฟฟ้าที่ระบุ',
            ], 404);
        }

        $latest = $powerPlant->latestReading;

        // พลังงานวันนี้ (MWh) ประมาณจากค่าเฉลี่ยกำลังผลิต × ชั่วโมงที่ผ่านมาของวัน
        $avgTodayMw = (float) $powerPlant->readings()
            ->whereDate('recorded_at', today())
            ->avg('output_mw');
        $hoursPassed = today()->diffInMinutes(now()) / 60;
        $energyTodayMwh = round($avgTodayMw * $hoursPassed, 1);

        // 20 ค่าล่าสุดสำหรับกราฟเส้น (เรียงใหม่→เก่า แอปจะกลับลำดับเอง)
        $readings = $powerPlant->readings()
            ->orderByDesc('recorded_at')
            ->limit(20)
            ->get()
            ->map(fn ($r) => [
                'output_mw'   => $r->output_mw,
                'recorded_at' => $r->recorded_at->toIso8601String(),
            ]);

        return response()->json([
            'message' => 'เรียกดูข้อมูลโรงไฟฟ้าสำเร็จ',
            'data'    => [
                ...$this->plantSummary($powerPlant),
                'frequency_hz'     => $latest?->frequency_hz ?? 0,
                'voltage_kv'       => $latest?->voltage_kv ?? 0,
                'energy_today_mwh' => $energyTodayMwh,
                'readings'         => $readings,
            ],
        ]);
    }

    /**
     * POST /api/v1/power-plants
     * สร้างโรงไฟฟ้า (Power Plant) ใหม่
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name'     => 'required|string|max:255|min:3',
            'code'     => 'required|string|max:50|min:2',
            'type'     => 'required|string|max:50|min:2',
            'capacity_mw' => 'required|numeric|min:0',
            'province' => 'required|string|max:100|min:2',
        ]);

        $powerPlant = PowerPlant::create($validatedData);

        return response()->json([
            'message' => 'สร้างโรงไฟฟ้าใหม่สำเร็จ',
            'data'    => $powerPlant,
        ], 201);
    }

    /**
     * รูปแบบ JSON ที่แอปใช้ (Plant.fromJson):
     * current_output_mw จากค่าอ่านล่าสุด + status จาก is_active
     */
    private function plantSummary(PowerPlant $plant): array
    {
        return [
            'id'                => $plant->id,
            'name'              => $plant->name,
            'code'              => $plant->code,
            'type'              => $plant->type,
            'province'          => $plant->province,
            'capacity_mw'       => (float) $plant->capacity_mw,
            'current_output_mw' => $plant->latestReading?->output_mw ?? 0,
            'status'            => $plant->is_active ? 'online' : 'offline',
            'is_active'         => $plant->is_active,
        ];
    }
}
