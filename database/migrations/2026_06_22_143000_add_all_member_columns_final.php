<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('members')) {
            return;
        }

        Schema::table('members', function (Blueprint $table) {
            $columns = [
                'phone' => ['string', 'nullable'],
                'email' => ['string', 'nullable'],
                'choir_role' => ['string', 'nullable'],
                'choir_group_id' => ['unsignedBigInteger', 'nullable'],
                'date_deceased' => ['timestamp', 'nullable'],
                'is_active' => ['boolean', 'default:true'],
                'is_choir' => ['boolean', 'default:false'],
                'is_deceased' => ['boolean', 'default:false'],
            ];

            foreach ($columns as $column => $options) {
                if (!Schema::hasColumn('members', $column)) {
                    $type = $options[0];
                    $params = $options[1] ?? null;
                    
                    if ($type === 'string') {
                        $table->string($column)->nullable();
                    } elseif ($type === 'boolean') {
                        if (strpos($params, 'true') !== false) {
                            $table->boolean($column)->default(true);
                        } else {
                            $table->boolean($column)->default(false);
                        }
                    } elseif ($type === 'timestamp') {
                        $table->timestamp($column)->nullable();
                    } elseif ($type === 'unsignedBigInteger') {
                        $table->unsignedBigInteger($column)->nullable();
                    }
                }
            }
        });
    }

    public function down()
    {
        if (!Schema::hasTable('members')) {
            return;
        }

        Schema::table('members', function (Blueprint $table) {
            $columns = ['phone', 'email', 'choir_role', 'choir_group_id', 'date_deceased'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('members', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
