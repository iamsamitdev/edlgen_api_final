@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')

    @php
        $statusLabels = ['open' => 'เปิดเคส', 'investigating' => 'กำลังตรวจสอบ', 'resolved' => 'แก้ไขแล้ว'];
        $severityLabels = ['low' => 'ต่ำ', 'medium' => 'ปานกลาง', 'high' => 'สูง', 'critical' => 'วิกฤต'];
        $severityColors = ['low' => 'var(--series-1)', 'medium' => 'var(--series-2)', 'high' => 'var(--series-3)', 'critical' => 'var(--series-5)'];

        $trendMax = max(1, collect($trend)->max('total'));
        $chartW = 560; $chartH = 160; $padX = 10; $padY = 10;
        $stepX = $trend ? ($chartW - $padX * 2) / max(1, count($trend) - 1) : 0;
        $points = collect($trend)->values()->map(function ($point, $i) use ($stepX, $padX, $chartH, $padY, $trendMax) {
            $x = $padX + $stepX * $i;
            $y = $chartH - $padY - (($point['total'] / $trendMax) * ($chartH - $padY * 2));
            return "{$x},{$y}";
        })->implode(' ');

        $severityTotal = max(1, collect($bySeverity)->sum('total'));
        $radius = 52; $circumference = 2 * M_PI * $radius; $offsetAcc = 0;
        $plantMax = max(1, $byPlant->max('total') ?? 1);
    @endphp

    {{-- ── Slicer / ตัวกรอง ── --}}
    <form method="GET" action="{{ route('dashboard') }}" class="slicer-panel">
        <div class="slicer-field">
            <label>สถานะ</label>
            <select name="status">
                <option value="">ทั้งหมด</option>
                @foreach ($statusLabels as $value => $label)
                    <option value="{{ $value }}" @selected($filters['status'] === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="slicer-field">
            <label>ความรุนแรง</label>
            <select name="severity">
                <option value="">ทั้งหมด</option>
                @foreach ($severityLabels as $value => $label)
                    <option value="{{ $value }}" @selected($filters['severity'] === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="slicer-field">
            <label>โรงไฟฟ้า</label>
            <select name="power_plant_id">
                <option value="">ทั้งหมด</option>
                @foreach ($plants as $plant)
                    <option value="{{ $plant->id }}" @selected((int) $filters['power_plant_id'] === $plant->id)>{{ $plant->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="slicer-field">
            <label>จากวันที่</label>
            <input type="date" name="from" value="{{ request('from') }}">
        </div>
        <div class="slicer-field">
            <label>ถึงวันที่</label>
            <input type="date" name="to" value="{{ request('to') }}">
        </div>
        <div class="slicer-field" style="flex:1; min-width:160px;">
            <label>ค้นหา</label>
            <input type="text" name="q" placeholder="หัวข้อ / รายละเอียด" value="{{ $filters['q'] }}">
        </div>
        <div class="slicer-actions">
            <button type="submit" class="btn">กรองข้อมูล</button>
            <a href="{{ route('dashboard') }}" class="btn secondary">ล้างตัวกรอง</a>
        </div>
    </form>

    {{-- ── KPI ── --}}
    <div class="kpi-grid">
        <div class="card kpi-card">
            <span class="label">ทั้งหมด</span>
            <span class="value">{{ number_format($kpis['total']) }}</span>
        </div>
        <div class="card kpi-card">
            <span class="label">เปิดเคส</span>
            <span class="value" style="color: var(--bad);">{{ number_format($kpis['open']) }}</span>
        </div>
        <div class="card kpi-card">
            <span class="label">กำลังตรวจสอบ</span>
            <span class="value" style="color: var(--series-3);">{{ number_format($kpis['investigating']) }}</span>
        </div>
        <div class="card kpi-card">
            <span class="label">แก้ไขแล้ว</span>
            <span class="value" style="color: var(--good);">{{ number_format($kpis['resolved']) }}</span>
        </div>
        <div class="card kpi-card">
            <span class="label">วิกฤต</span>
            <span class="value" style="color: var(--series-5);">{{ number_format($kpis['critical']) }}</span>
        </div>
    </div>

    {{-- ── กราฟ ── --}}
    <div class="chart-row">
        <div class="card">
            <h3>แนวโน้มเหตุขัดข้อง 14 วันล่าสุด</h3>
            <svg viewBox="0 0 {{ $chartW }} {{ $chartH }}" width="100%" style="margin-top:12px; overflow:visible;">
                @for ($i = 0; $i <= 3; $i++)
                    <line x1="{{ $padX }}" x2="{{ $chartW - $padX }}"
                          y1="{{ $padY + $i * ($chartH - $padY * 2) / 3 }}" y2="{{ $padY + $i * ($chartH - $padY * 2) / 3 }}"
                          stroke="var(--gridline)" stroke-width="1" />
                @endfor
                <polyline points="{{ $points }}" fill="none" stroke="var(--series-1)" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round" />
                @foreach ($trend as $i => $point)
                    <circle cx="{{ $padX + $stepX * $i }}" cy="{{ $chartH - $padY - (($point['total'] / $trendMax) * ($chartH - $padY * 2)) }}" r="3" fill="var(--series-1)">
                        <title>{{ \Carbon\Carbon::parse($point['day'])->format('d M') }}: {{ $point['total'] }} เหตุการณ์</title>
                    </circle>
                @endforeach
            </svg>
            <div class="legend">
                <div class="item"><span>{{ \Carbon\Carbon::parse($trend[0]['day'])->format('d M') }}</span></div>
                <div class="item" style="margin-left:auto;"><span>{{ \Carbon\Carbon::parse(end($trend)['day'])->format('d M') }}</span></div>
            </div>
        </div>

        <div class="card">
            <h3>สัดส่วนตามความรุนแรง</h3>
            <div style="display:flex; align-items:center; gap:20px; margin-top:12px;">
                <svg viewBox="0 0 120 120" width="130" height="130" style="flex:none;">
                    <g transform="rotate(-90 60 60)">
                        @foreach ($bySeverity as $item)
                            @php
                                $frac = $item['total'] / $severityTotal;
                                $dash = $frac * $circumference;
                                $gap = $circumference - $dash;
                            @endphp
                            <circle cx="60" cy="60" r="{{ $radius }}" fill="none"
                                    stroke="{{ $severityColors[$item['severity']] }}" stroke-width="18"
                                    stroke-dasharray="{{ $dash }} {{ $gap }}" stroke-dashoffset="{{ -$offsetAcc }}" />
                            @php $offsetAcc += $dash; @endphp
                        @endforeach
                    </g>
                    <text x="60" y="65" text-anchor="middle" font-size="20" font-weight="700" fill="var(--text-primary)">{{ $severityTotal }}</text>
                </svg>
                <div class="legend" style="flex-direction:column; margin-top:0;">
                    @foreach ($bySeverity as $item)
                        <div class="item">
                            <span class="dot" style="background:{{ $severityColors[$item['severity']] }};"></span>
                            {{ $severityLabels[$item['severity']] }}  {{ $item['total'] }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="margin-bottom:20px;">
        <h3>เหตุขัดข้องตามโรงไฟฟ้า (Top 8)</h3>
        <div style="display:flex; flex-direction:column; gap:10px; margin-top:14px;">
            @forelse ($byPlant as $item)
                <div>
                    <div style="display:flex; justify-content:space-between; font-size:13px; margin-bottom:4px;">
                        <span>{{ $item->plant_name }}</span>
                        <strong>{{ $item->total }}</strong>
                    </div>
                    <div style="background:var(--gridline); border-radius:6px; height:8px; overflow:hidden;">
                        <div style="width:{{ ($item->total / $plantMax) * 100 }}%; background:var(--series-1); height:100%;"></div>
                    </div>
                </div>
            @empty
                <p class="empty-state" style="padding:8px 0;">ไม่มีข้อมูล</p>
            @endforelse
        </div>
    </div>

    {{-- ── ตารางรายการแจ้งเหตุ ── --}}
    <div class="card">
        <h3>รายการแจ้งเหตุล่าสุด</h3>
        <div style="overflow-x:auto; margin-top:12px;">
            <table>
                <thead>
                    <tr>
                        <th>วันที่เกิดเหตุ</th>
                        <th>หัวข้อ</th>
                        <th>โรงไฟฟ้า</th>
                        <th>ความรุนแรง</th>
                        <th>สถานะ</th>
                        <th>ผู้แจ้ง</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($incidents as $incident)
                        <tr>
                            <td>{{ $incident->occurred_at?->format('d/m/Y H:i') }}</td>
                            <td>
                                <strong>{{ $incident->title }}</strong>
                                @if ($incident->description)
                                    <div style="color:var(--text-muted); font-size:12.5px; margin-top:2px;">{{ \Illuminate\Support\Str::limit($incident->description, 80) }}</div>
                                @endif
                            </td>
                            <td>{{ $incident->powerPlant?->name ?? '' }}</td>
                            <td><span class="badge {{ $incident->severity }}">{{ $severityLabels[$incident->severity] ?? $incident->severity }}</span></td>
                            <td><span class="badge {{ $incident->status }}">{{ $statusLabels[$incident->status] ?? $incident->status }}</span></td>
                            <td>{{ $incident->reporter?->name ?? '' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">ไม่พบข้อมูลแจ้งเหตุตามเงื่อนไขที่เลือก</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($incidents->hasPages())
            <div class="pagination">
                @if ($incidents->onFirstPage())
                    <span>&laquo; ก่อนหน้า</span>
                @else
                    <a href="{{ $incidents->previousPageUrl() }}">&laquo; ก่อนหน้า</a>
                @endif

                @for ($page = 1; $page <= $incidents->lastPage(); $page++)
                    <a href="{{ $incidents->url($page) }}" class="{{ $page === $incidents->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                @endfor

                @if ($incidents->hasMorePages())
                    <a href="{{ $incidents->nextPageUrl() }}">ถัดไป &raquo;</a>
                @else
                    <span>ถัดไป &raquo;</span>
                @endif
            </div>
        @endif
    </div>

@endsection
