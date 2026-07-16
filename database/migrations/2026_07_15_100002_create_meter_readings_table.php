<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * ตารางบันทึกค่ามิเตอร์รายชั่วโมง (ฟีเจอร์ Meter Reading + Optimistic Update)
     * กติกา: มิเตอร์ 1 ตัว บันทึกได้ 1 ครั้งต่อชั่วโมง → unique(meter_code, recorded_for)
     */
    public function up(): void
    {
        Schema::create('meter_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('power_plant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('recorded_by')->nullable()->constrained('users');
            $table->string('meter_code', 20);            // รูปแบบ MTR-0000
            $table->decimal('reading_kwh', 12, 2);       // 0 - 99,999,999
            $table->timestamp('recorded_for')->index();  // ชั่วโมงเต็ม เช่น 2026-07-15 14:00:00
            $table->timestamps();

            $table->unique(['meter_code', 'recorded_for']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meter_readings');
    }
};
