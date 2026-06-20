<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sunday_attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('church_id');
            $table->unsignedBigInteger('member_id')->nullable();
            $table->date('service_date');
            $table->string('service_type')->default('Sunday Service');
            $table->string('status')->default('Absent'); // Present, Absent, Late
            $table->string('visitor_name')->nullable();
            $table->boolean('is_visitor')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('church_id');
            $table->index('service_date');
            $table->index('member_id');
            $table->foreign('church_id')->references('id')->on('churches')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sunday_attendances');
    }
};