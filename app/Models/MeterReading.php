<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MeterReading extends Model
{
    protected $fillable = [
        'power_plant_id', 'recorded_by', 'meter_code', 'reading_kwh', 'recorded_for',
    ];

    protected function casts(): array
    {
        return [
            'reading_kwh'  => 'float',
            'recorded_for' => 'datetime',
        ];
    }

    public function powerPlant(): BelongsTo
    {
        return $this->belongsTo(PowerPlant::class);
    }

    /**
     * แปลงเป็น JSON รูปแบบที่แอป Flutter ใช้ (MeterReading.fromJson)
     */
    public function toApiArray(): array
    {
        return [
            'id'           => $this->id,
            'plant_id'     => (int) $this->power_plant_id,
            'meter_code'   => $this->meter_code,
            'reading_kwh'  => $this->reading_kwh,
            'recorded_for' => $this->recorded_for->format('Y-m-d\TH:i:s'),
        ];
    }
}
