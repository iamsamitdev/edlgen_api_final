<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('energy_readings', function (Blueprint $table) {
            $table->id();
            // FK → power_plants ลบโรงไฟฟ้าแล้วค่าการอ่านหายตาม (เฉพาะข้อมูลจำลอง)
            $table->foreignId('power_plant_id')->constrained()->cascadeOnDelete();
            $table->decimal('output_mw', 8, 2);          // กำลังผลิตขณะนั้น (MW)
            $table->decimal('frequency_hz', 5, 2);       // ความถี่ระบบ เช่น 50.02
            $table->decimal('voltage_kv', 6, 2);         // แรงดัน (kV)
            $table->timestamp('recorded_at')->index();   // เวลาที่อ่านค่า (index เพื่อ query ช่วงเวลา)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('energy_readings');
    }
};
