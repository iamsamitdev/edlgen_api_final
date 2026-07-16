<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Incident extends Model
{
    protected $fillable = [
        'power_plant_id', 'reported_by', 'title', 'description',
        'severity', 'status', 'occurred_at',
        'latitude', 'longitude', 'photo_path',
    ];

    protected function casts(): array
    {
        return [
            'occurred_at' => 'datetime',
            'latitude'    => 'float',
            'longitude'   => 'float',
        ];
    }

    public function powerPlant(): BelongsTo
    {
        return $this->belongsTo(PowerPlant::class);
    }

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    /**
     * แปลงเป็น JSON รูปแบบที่แอป Flutter ใช้ (Incident.fromJson)
     */
    public function toApiArray(): array
    {
        return [
            'id'          => $this->id,
            // cast เป็น int เสมอ - ค่าจาก multipart form จะเป็น string "1"
            'plant_id'    => (int) $this->power_plant_id,
            'plant_name'  => $this->powerPlant?->name,
            'title'       => $this->title,
            'description' => $this->description ?? '',
            'severity'    => $this->severity,
            'status'      => $this->status,
            'latitude'    => $this->latitude,
            'longitude'   => $this->longitude,
            'photo_url'   => $this->photo_path
                ? Storage::disk('public')->url($this->photo_path)
                : null,
            'reported_by' => $this->reporter?->name,
            'occurred_at' => $this->occurred_at?->toIso8601String(),
        ];
    }
}
