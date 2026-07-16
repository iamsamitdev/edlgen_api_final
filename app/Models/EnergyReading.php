<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnergyReading extends Model
{
    protected $fillable = [
        'power_plant_id', 'output_mw', 'frequency_hz', 'voltage_kv', 'recorded_at',
    ];

    protected function casts(): array
    {
        return [
            'output_mw'    => 'float',
            'frequency_hz' => 'float',
            'voltage_kv'   => 'float',
            'recorded_at'  => 'datetime',
        ];
    }

    public function powerPlant(): BelongsTo
    {
        return $this->belongsTo(PowerPlant::class);
    }
}
