<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\MeterReading;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeterReadingController extends Controller
{
    /**
     * GET /api/v1/meter-readings/today
     * รายการค่ามิเตอร์ที่บันทึก "วันนี้" เรียงล่าสุดขึ้นก่อน
     */
    public function today(): JsonResponse
    {
        $readings = MeterReading::whereDate('recorded_for', today())
            ->orderByDesc('recorded_for')
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'message' => 'เรียกดูค่ามิเตอร์วันนี้สำเร็จ',
            'data'    => $readings->map(fn (MeterReading $r) => $r->toApiArray()),
        ]);
    }

    /**
     * POST /api/v1/meter-readings
     * บันทึกค่ามิเตอร์รายชั่วโมง
     * กติกาต้องตรงกับ validate ฝั่งแอป: ^MTR-\d{4}$ และ 0-99,999,999
     * ชั่วโมงเดิม+มิเตอร์เดิมบันทึกซ้ำ → 409 (แอปใช้ rollback Optimistic Update)
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'plant_id'     => 'required|integer|exists:power_plants,id',
            'meter_code'   => ['required', 'regex:/^MTR-\d{4}$/'],
            'reading_kwh'  => 'required|numeric|min:0|max:99999999',
            'recorded_for' => 'required|date_format:Y-m-d H:00:00',
        ]);

        // เช็กซ้ำ: มิเตอร์ 1 ตัว บันทึกได้ชั่วโมงละ 1 ครั้ง
        $duplicate = MeterReading::where('meter_code', $validated['meter_code'])
            ->where('recorded_for', $validated['recorded_for'])
            ->exists();

        if ($duplicate) {
            return response()->json([
                'message' => 'ชั่วโมงนี้บันทึกค่ามิเตอร์นี้ไปแล้ว',
            ], 409);
        }

        $reading = MeterReading::create([
            'power_plant_id' => $validated['plant_id'],
            'recorded_by'    => $request->user()->id,
            'meter_code'     => $validated['meter_code'],
            'reading_kwh'    => $validated['reading_kwh'],
            'recorded_for'   => $validated['recorded_for'],
        ]);

        return response()->json([
            'message' => 'บันทึกค่ามิเตอร์สำเร็จ',
            'data'    => $reading->toApiArray(),
        ], 201);
    }
}
