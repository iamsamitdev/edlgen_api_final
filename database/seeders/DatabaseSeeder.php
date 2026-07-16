<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // วิศวกรทดสอบของ EDL-Gen (ข้อมูลจำลอง)
        // ใช้ firstOrCreate แทน create เพื่อให้ Seeder รันซ้ำได้อย่างปลอดภัย
        // (จำเป็นสำหรับ Deploy บน Render Free Tier ที่ต้องรัน db:seed อัตโนมัติทุกครั้งที่ container start)
        User::firstOrCreate(
            ['email' => 'engineer@edlgen.la'],
            [
                'name'     => 'Somphone Engineer',
                'password' => Hash::make('password123'),
            ],
        );

        $this->call([
            PowerPlantSeeder::class,
            DailyReportSeeder::class,
        ]);
    }
}