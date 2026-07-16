<?php

namespace Database\Seeders;

use App\Models\DailyReport;
use App\Models\PowerPlant;
use Illuminate\Database\Seeder;

class DailyReportSeeder extends Seeder
{
    /**
     * รายงานการผลิตรายวันย้อนหลัง 30 วัน ของทุกโรงไฟฟ้า (ข้อมูลจำลอง)
     * ใช้ firstOrCreate ตาม (plant, report_date) → รันซ้ำได้ไม่มีข้อมูลซ้ำ
     */
    public function run(): void
    {
        $plants = PowerPlant::all();

        foreach ($plants as $plant) {
            foreach (range(0, 29) as $daysAgo) {
                $date = today()->subDays($daysAgo)->format('Y-m-d');

                // สมมติเดินเครื่องเฉลี่ย 55-92% ของกำลังการผลิตตลอดวัน
                $loadFactor = mt_rand(55, 92) / 100;
                $energyMwh  = round((float) $plant->capacity_mw * 24 * $loadFactor, 2);
                $peakMw     = round((float) $plant->capacity_mw * (mt_rand(88, 99) / 100), 2);

                DailyReport::firstOrCreate(
                    ['power_plant_id' => $plant->id, 'report_date' => $date],
                    [
                        'energy_mwh'    => $energyMwh,
                        'peak_mw'       => $peakMw,
                        'availability'  => mt_rand(940, 999) / 10,   // 94.0 - 99.9 %
                        'water_level_m' => mt_rand(1950, 2100) / 10, // 195.0 - 210.0 m
                    ],
                );
            }
        }
    }
}
