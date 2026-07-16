<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * เพิ่มคอลัมน์ให้ตาราง incidents รองรับฟีเจอร์แจ้งเหตุจากมือถือ:
     * - พิกัด GPS จุดเกิดเหตุ (latitude/longitude)
     * - path รูปถ่ายที่แนบมา (photo_path)
     */
    public function up(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->decimal('latitude', 10, 7)->nullable()->after('occurred_at');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            $table->string('photo_path')->nullable()->after('longitude');
        });
    }

    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude', 'photo_path']);
        });
    }
};
