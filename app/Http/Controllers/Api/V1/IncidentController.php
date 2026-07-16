<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    /**
     * GET /api/v1/incidents
     * รายการเหตุขัดข้องทั้งหมด เรียงเหตุล่าสุดขึ้นก่อน (หน้า Notifications)
     */
    public function index(): JsonResponse
    {
        $incidents = Incident::with(['powerPlant', 'reporter'])
            ->orderByDesc('occurred_at')
            ->limit(50)
            ->get();

        return response()->json([
            'message' => 'เรียกดูรายการเหตุขัดข้องสำเร็จ',
            'data'    => $incidents->map(fn (Incident $i) => $i->toApiArray()),
        ]);
    }

    /**
     * GET /api/v1/incidents/{id}
     * รายละเอียดเหตุขัดข้อง (หน้า Incident Detail + timeline)
     */
    public function show(int $id): JsonResponse
    {
        $incident = Incident::with(['powerPlant', 'reporter'])->find($id);

        if (!$incident) {
            return response()->json(['message' => 'ไม่พบเหตุขัดข้องที่ระบุ'], 404);
        }

        return response()->json([
            'message' => 'เรียกดูเหตุขัดข้องสำเร็จ',
            'data'    => $incident->toApiArray(),
        ]);
    }

    /**
     * POST /api/v1/incidents  (multipart/form-data มีไฟล์รูปแนบ)
     * แจ้งเหตุใหม่จากแอปมือถือ: ฟอร์ม + รูปถ่าย + พิกัด GPS
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'plant_id'    => 'required|integer|exists:power_plants,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'severity'    => 'required|in:low,medium,high,critical',
            'latitude'    => 'required|numeric|between:-90,90',
            'longitude'   => 'required|numeric|between:-180,180',
            'photo'       => 'required|image|max:5120', // ไม่เกิน 5 MB
        ]);

        // เก็บรูปที่ storage/app/public/incidents (เข้าถึงผ่าน /storage/incidents/...)
        $photoPath = $request->file('photo')->store('incidents', 'public');

        $incident = Incident::create([
            'power_plant_id' => $validated['plant_id'],
            'reported_by'    => $request->user()->id,
            'title'          => $validated['title'],
            'description'    => $validated['description'] ?? '',
            'severity'       => $validated['severity'],
            'status'         => 'open',
            'occurred_at'    => now(),
            'latitude'       => $validated['latitude'],
            'longitude'      => $validated['longitude'],
            'photo_path'     => $photoPath,
        ]);

        $incident->load(['powerPlant', 'reporter']);

        return response()->json([
            'message' => 'แจ้งเหตุขัดข้องสำเร็จ',
            'data'    => $incident->toApiArray(),
        ], 201);
    }
}
