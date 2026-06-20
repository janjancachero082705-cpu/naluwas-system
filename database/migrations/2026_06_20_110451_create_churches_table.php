<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up()
    {
        Schema::create('churches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('subdomain')->unique();
            $table->string('denomination')->nullable();
            $table->string('location')->nullable();
            $table->string('logo')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('church_id')->nullable()->constrained()->onDelete('cascade');
            $table->dropColumn('email_verified_at');
        });

        Schema::table('money_transactions', function (Blueprint $table) {
            $table->foreignId('church_id')->nullable()->constrained()->onDelete('cascade');
        });

        Schema::table('choir_practices', function (Blueprint $table) {
            $table->foreignId('church_id')->nullable()->constrained()->onDelete('cascade');
        });

        // members already has church_id from create_members_table — not touched here.
        // attendances doesn't exist yet at this point in the timeline — handled later.
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['church_id']);
            $table->dropColumn('church_id');
        });
        Schema::table('money_transactions', function (Blueprint $table) {
            $table->dropForeign(['church_id']);
            $table->dropColumn('church_id');
        });
        Schema::table('choir_practices', function (Blueprint $table) {
            $table->dropForeign(['church_id']);
            $table->dropColumn('church_id');
        });
        Schema::dropIfExists('churches');
    }
};