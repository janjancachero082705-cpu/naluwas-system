<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MemberSeeder extends Seeder
{
    public function run()
    {
        // Create sample members
        Member::create(['name' => 'Juan Dela Cruz', 'role' => 'Praise Team', 'joined_date' => now()]);
        Member::create(['name' => 'Maria Santos', 'role' => 'Usher', 'joined_date' => now()]);
        Member::create(['name' => 'Jose Rizal', 'role' => 'Pastor', 'joined_date' => now()]);
        Member::create(['name' => 'Ana Reyes', 'role' => 'Youth', 'joined_date' => now()]);
        
        // Create admin user if not exists
        if (!User::where('email', 'admin@church.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@church.com',
                'password' => Hash::make('password123'),
                'is_admin' => true
            ]);
        }
    }
}