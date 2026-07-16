<?php
// database/seeders/PowerPlantSeeder.php
namespace Database\Seeders;

use App\Models\PowerPlant;
use Illuminate\Database\Seeder;

class PowerPlantSeeder extends Seeder
{
    public function run(): void
    {
        // ข้อมูลจำลองอิงชื่อโรงไฟฟ้าจริงเพื่อความคุ้นเคย แต่ตัวเลขสมมติทั้งหมด
        $plants = [
            ['name' => 'Nam Ngum 1',   'code' => 'NN1', 'type' => 'hydro',   'capacity_mw' => 155.00, 'province' => 'Vientiane'],
            ['name' => 'Nam Ngum 2',   'code' => 'NN2', 'type' => 'hydro',   'capacity_mw' => 615.00, 'province' => 'Vientiane'],
            ['name' => 'Theun-Hinboun','code' => 'THB', 'type' => 'hydro',   'capacity_mw' => 500.00, 'province' => 'Bolikhamxay'],
            ['name' => 'Houay Ho',     'code' => 'HH',  'type' => 'hydro',   'capacity_mw' => 152.00, 'province' => 'Champasak'],
            ['name' => 'Solar Farm 1', 'code' => 'SF1', 'type' => 'solar',   'capacity_mw' => 30.00,  'province' => 'Savannakhet'],
        ];

        foreach ($plants as $plant) {
            // ใช้ firstOrCreate ตาม code (unique) แทน create เพื่อให้รัน Seeder ซ้ำได้โดยไม่ error/ไม่ได้ข้อมูลซ้ำ
            $created = PowerPlant::firstOrCreate(['code' => $plant['code']], $plant);

            // เติมค่าการอ่านเมื่อ "ไม่มีข้อมูลใน 24 ชม. ล่าสุด" เท่านั้น
            // → รันซ้ำวันเดียวกันไม่ได้ข้อมูลซ้ำ แต่ deploy วันถัดไปจะได้กราฟสดใหม่เสมอ
            // (จำเป็นบน Render Free ที่รัน db:seed ทุกครั้งที่ container ตื่น
            //  และโปรเจกต์นี้ไม่มีตัว broadcast ค่า real-time จาก server แล้ว)
            $hasRecent = $created->readings()
                ->where('recorded_at', '>', now()->subDay())
                ->exists();
            if ($hasRecent) {
                continue;
            }

            // ล้างค่าอ่านเก่ากว่า 7 วัน กันตารางโตเรื่อย ๆ บน Aiven Free (1GB)
            $created->readings()->where('recorded_at', '<', now()->subDays(7))->delete();

            // สร้างค่าการอ่านย้อนหลัง 24 ชั่วโมง ทุก 1 ชั่วโมง
            foreach (range(1, 24) as $hour) {
                $created->readings()->create([
                    'output_mw'    => round($created->capacity_mw * (mt_rand(55, 92) / 100), 2),
                    'frequency_hz' => round(mt_rand(4985, 5015) / 100, 2),  // 49.85 - 50.15 Hz
                    'voltage_kv'   => round(mt_rand(2180, 2320) / 10, 2),   // 218.0 - 232.0 kV
                    'recorded_at'  => now()->subHours($hour),
                ]);
            }
        }
    }
}