<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DailyReport extends Model
{
    protected $fillable = [
        'power_plant_id', 'report_date', 'energy_mwh',
        'peak_mw', 'availability', 'water_level_m',
    ];

    protected function casts(): array
    {
        return [
            'report_date'   => 'date:Y-m-d',
            'energy_mwh'    => 'float',
            'peak_mw'       => 'float',
            'availability'  => 'float',
            'water_level_m' => 'float',
        ];
    }

    public function powerPlant(): BelongsTo
    {
        return $this->belongsTo(PowerPlant::class);
    }

    /**
     * แปลงเป็น JSON รูปแบบที่แอป Flutter ใช้ (DailyReport.fromJson)
     */
    public function toApiArray(): array
    {
        return [
            'id'            => $this->id,
            'plant_id'      => $this->power_plant_id,
            'plant_name'    => $this->powerPlant?->name,
            'report_date'   => $this->report_date->format('Y-m-d'),
            'energy_mwh'    => $this->energy_mwh,
            'peak_mw'       => $this->peak_mw,
            'availability'  => $this->availability,
            'water_level_m' => $this->water_level_m,
        ];
    }
}
