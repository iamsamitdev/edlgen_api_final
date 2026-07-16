<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('power_plants', function (Blueprint $table) {
            $table->id();
            $table->string('name');                      // เช่น "Nam Ngum 1"
            $table->string('code', 20)->unique();        // เช่น "NN1"
            $table->enum('type', ['hydro', 'solar', 'thermal'])->default('hydro');
            $table->decimal('capacity_mw', 8, 2);        // กำลังผลิตติดตั้ง (MW)
            $table->string('province');                  // แขวงที่ตั้ง เช่น "Vientiane"
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('power_plants');
    }
};