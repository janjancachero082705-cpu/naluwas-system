<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'Training Pastor', 'slug' => 'training_pastor', 'icon' => 'fa-church', 'color' => 'danger'],
            ['name' => 'Palagkanta', 'slug' => 'palagkanta', 'icon' => 'fa-microphone-alt', 'color' => 'primary'],
            ['name' => 'Instruments', 'slug' => 'instruments', 'icon' => 'fa-guitar', 'color' => 'info'],
            ['name' => 'Youth Leader', 'slug' => 'youth_leader', 'icon' => 'fa-users', 'color' => 'warning'],
            ['name' => 'AGAK Mentor', 'slug' => 'agak_mentor', 'icon' => 'fa-chalkboard-teacher', 'color' => 'secondary'],
            ['name' => 'Palagbulig (Lalaki)', 'slug' => 'palagbulig_lalaki', 'icon' => 'fa-male', 'color' => 'success'],
            ['name' => 'Palagbulig (Babae)', 'slug' => 'palagbulig_babae', 'icon' => 'fa-female', 'color' => 'success'],
            ['name' => 'Gahawid sa Offering', 'slug' => 'offering', 'icon' => 'fa-hand-holding-usd', 'color' => 'dark'],
            ['name' => 'Gahawid sa Computer', 'slug' => 'computer', 'icon' => 'fa-laptop', 'color' => 'info'],
            ['name' => 'Palagdasig', 'slug' => 'palagdasig', 'icon' => 'fa-heart', 'color' => 'danger'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        $this->command->info('Roles seeded successfully!');
    }
}