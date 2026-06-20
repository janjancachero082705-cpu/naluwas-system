<?php
// database/seeders/ChoirGroupsSeeder.php

namespace Database\Seeders;

use App\Models\ChoirGroup;
use App\Models\Church;
use Illuminate\Database\Seeder;

class ChoirGroupsSeeder extends Seeder
{
    public function run()
    {
        $churches = Church::all();
        
        foreach ($churches as $church) {
            $groups = [
                ['name' => 'Group A', 'color' => '#ef4444', 'display_order' => 1],
                ['name' => 'Group B', 'color' => '#3b82f6', 'display_order' => 2],
                ['name' => 'Group C', 'color' => '#10b981', 'display_order' => 3],
                ['name' => 'Group D', 'color' => '#f59e0b', 'display_order' => 4],
            ];
            
            foreach ($groups as $group) {
                ChoirGroup::create([
                    'church_id' => $church->id,
                    'name' => $group['name'],
                    'color' => $group['color'],
                    'display_order' => $group['display_order'],
                    'is_active' => true,
                ]);
            }
        }
    }
}