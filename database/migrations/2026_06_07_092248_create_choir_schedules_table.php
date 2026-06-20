<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('choir_schedules', function (Blueprint $table) {
            $table->id();
            $table->date('service_date');
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->string('role')->nullable(); // Leader, Vocalist, Instrumentalist
            $table->string('voice_part')->nullable(); // Soprano, Alto, Tenor, Bass
            $table->text('notes')->nullable();
            $table->enum('status', ['Scheduled', 'Present', 'Absent', 'Excused'])->default('Scheduled');
            $table->timestamps();
            
            $table->unique(['service_date', 'member_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('choir_schedules');
    }
};