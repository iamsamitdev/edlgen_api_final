<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('power_plant_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reported_by')->constrained('users');
            $table->string('title');                                  // หัวข้อเหตุขัดข้อง
            $table->text('description')->nullable();
            $table->enum('severity', ['low', 'medium', 'high', 'critical']);
            $table->enum('status', ['open', 'investigating', 'resolved'])->default('open');
            $table->timestamp('occurred_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
