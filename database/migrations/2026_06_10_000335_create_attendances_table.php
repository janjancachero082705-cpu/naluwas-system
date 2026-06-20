<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('attendances')) {
            Schema::create('attendances', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('member_id');
                $table->date('service_date');
                $table->enum('service_type', ['Sunday Service', 'Wednesday Prayer', 'Choir Practice', 'Youth Service', 'Other'])->default('Sunday Service');
                $table->enum('status', ['Present', 'Absent', 'Late'])->default('Present');
                $table->time('check_in_time')->nullable();
                $table->string('role')->nullable();
                $table->text('notes')->nullable();
                $table->boolean('is_visitor')->default(false);
                $table->string('visitor_name')->nullable();
                $table->unsignedBigInteger('church_id')->nullable();
                $table->timestamps();
                
                $table->index('member_id');
                $table->index('church_id');
                $table->index('service_date');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};