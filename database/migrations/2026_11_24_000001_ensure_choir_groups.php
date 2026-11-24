<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('choir_groups')) {
            Schema::create('choir_groups', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('church_id')->nullable()->index();
                $table->string('name');
                $table->boolean('is_active')->default(true);
                $table->unsignedInteger('rotation_order')->default(0);
                $table->timestamps();
            });
        }

        if (Schema::hasTable('members')) {
            Schema::table('members', function (Blueprint $table) {
                if (!Schema::hasColumn('members', 'choir_group_id')) {
                    $table->unsignedBigInteger('choir_group_id')->nullable();
                }
                if (!Schema::hasColumn('members', 'choir_role')) {
                    $table->string('choir_role')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        // intentionally empty (safe)
    }
};