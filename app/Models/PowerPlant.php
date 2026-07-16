<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PowerPlant extends Model
{
    protected $fillable = [
        'name', 'code', 'type', 'capacity_mw', 'province', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'capacity_mw' => 'decimal:2',
            'is_active'   => 'boolean',
        ];
    }

    // โรงไฟฟ้า 1 แห่ง มีค่าการอ่านหลายรายการ
    public function readings(): HasMany
    {
        return $this->hasMany(EnergyReading::class);
    }

    // ค่าการอ่านล่าสุด 1 รายการ (ใช้โชว์กำลังผลิตปัจจุบัน)
    public function latestReading()
    {
        return $this->hasOne(EnergyReading::class)->latestOfMany('recorded_at');
    }

    // โรงไฟฟ้า 1 แห่ง มีเหตุขัดข้องหลายรายการ
    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class);
    }
}