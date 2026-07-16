<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\DailyReport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * GET /api/v1/reports/daily?date_from=&date_to=&plant_id=
     * รายงานการผลิตรายวัน กรองด้วยช่วงวันที่ + โรงไฟฟ้าได้
     */
    public function daily(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'date_from' => 'nullable|date_format:Y-m-d',
            'date_to'   => 'nullable|date_format:Y-m-d',
            'plant_id'  => 'nullable|integer|exists:power_plants,id',
        ]);

        $reports = DailyReport::with('powerPlant')
            ->when($validated['date_from'] ?? null,
                fn ($q, $from) => $q->whereDate('report_date', '>=', $from))
            ->when($validated['date_to'] ?? null,
                fn ($q, $to) => $q->whereDate('report_date', '<=', $to))
            ->when($validated['plant_id'] ?? null,
                fn ($q, $plantId) => $q->where('power_plant_id', $plantId))
            ->orderByDesc('report_date')
            ->limit(200)
            ->get();

        return response()->json([
            'message' => 'เรียกดูรายงานรายวันสำเร็จ',
            'data'    => $reports->map(fn (DailyReport $r) => $r->toApiArray()),
        ]);
    }
}
