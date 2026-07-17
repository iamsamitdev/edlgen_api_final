<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\PowerPlant;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * หน้า Dashboard แสดงข้อมูลแจ้งเหตุ (incidents) พร้อมตัวกรองและกราฟสรุป
     */
    public function index(Request $request): View
    {
        $filters = [
            'status'        => $request->string('status')->toString() ?: null,
            'severity'      => $request->string('severity')->toString() ?: null,
            'power_plant_id'=> $request->integer('power_plant_id') ?: null,
            'from'          => $request->date('from')?->startOfDay(),
            'to'            => $request->date('to')?->endOfDay(),
            'q'             => $request->string('q')->toString() ?: null,
        ];

        $query = Incident::query()->with(['powerPlant', 'reporter']);

        $this->applyFilters($query, $filters);

        // ── KPI การ์ดสรุป (นับจากผลลัพธ์ที่ผ่านตัวกรองแล้ว) ──
        $kpiBase = (clone $query);
        $kpis = [
            'total'          => (clone $kpiBase)->count(),
            'open'           => (clone $kpiBase)->where('status', 'open')->count(),
            'investigating'  => (clone $kpiBase)->where('status', 'investigating')->count(),
            'resolved'       => (clone $kpiBase)->where('status', 'resolved')->count(),
            'critical'       => (clone $kpiBase)->where('severity', 'critical')->count(),
        ];

        // ── ข้อมูลกราฟ: จำนวนเหตุขัดข้องต่อวัน 14 วันล่าสุด ──
        $trendStart = now()->subDays(13)->startOfDay();
        $trendQuery = Incident::query();
        $this->applyFilters($trendQuery, $filters);
        $trendRaw = $trendQuery
            ->where('occurred_at', '>=', $trendStart)
            ->selectRaw('DATE(occurred_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->pluck('total', 'day');

        $trend = [];
        for ($i = 13; $i >= 0; $i--) {
            $day = now()->subDays($i)->format('Y-m-d');
            $trend[] = ['day' => $day, 'total' => (int) ($trendRaw[$day] ?? 0)];
        }

        // ── ข้อมูลกราฟ: สัดส่วนตามระดับความรุนแรง ──
        $severityQuery = Incident::query();
        $this->applyFilters($severityQuery, $filters);
        $severityCounts = $severityQuery
            ->selectRaw('severity, COUNT(*) as total')
            ->groupBy('severity')
            ->pluck('total', 'severity');

        $severityLevels = ['low', 'medium', 'high', 'critical'];
        $bySeverity = collect($severityLevels)
            ->map(fn ($level) => ['severity' => $level, 'total' => (int) ($severityCounts[$level] ?? 0)])
            ->values()
            ->all();

        // ── ข้อมูลกราฟ: จำนวนเหตุขัดข้องตามโรงไฟฟ้า (top 8) ──
        $plantQuery = Incident::query();
        $this->applyFilters($plantQuery, $filters);
        $byPlant = $plantQuery
            ->join('power_plants', 'power_plants.id', '=', 'incidents.power_plant_id')
            ->selectRaw('power_plants.name as plant_name, COUNT(*) as total')
            ->groupBy('power_plants.name')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        // ── ตารางรายการล่าสุด (พร้อมแบ่งหน้า) ──
        $incidents = (clone $query)
            ->orderByDesc('occurred_at')
            ->paginate(10)
            ->withQueryString();

        $plants = PowerPlant::query()->orderBy('name')->get(['id', 'name']);

        return view('dashboard', [
            'kpis'       => $kpis,
            'trend'      => $trend,
            'bySeverity' => $bySeverity,
            'byPlant'    => $byPlant,
            'incidents'  => $incidents,
            'plants'     => $plants,
            'filters'    => $filters,
        ]);
    }

    /**
     * ใส่เงื่อนไขตัวกรองลงใน query (ใช้ร่วมกันทั้ง KPI, กราฟ และตาราง)
     */
    private function applyFilters($query, array $filters): void
    {
        $query
            ->when($filters['status'], fn ($q, $status) => $q->where('status', $status))
            ->when($filters['severity'], fn ($q, $severity) => $q->where('severity', $severity))
            ->when($filters['power_plant_id'], fn ($q, $plantId) => $q->where('power_plant_id', $plantId))
            ->when($filters['from'], fn ($q, $from) => $q->where('occurred_at', '>=', $from))
            ->when($filters['to'], fn ($q, $to) => $q->where('occurred_at', '<=', $to))
            ->when($filters['q'], fn ($q, $keyword) => $q->where(function ($sub) use ($keyword) {
                $sub->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            }));
    }
}
