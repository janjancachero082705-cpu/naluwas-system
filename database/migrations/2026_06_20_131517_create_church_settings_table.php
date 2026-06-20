<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('church_settings')) {
            Schema::create('church_settings', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('church_id');
                $table->string('church_name');
                $table->string('tagline')->nullable();
                $table->string('address')->nullable();
                $table->string('phone')->nullable();
                $table->string('logo_path')->nullable();
                $table->string('favicon_path')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('church_settings');
    }
};