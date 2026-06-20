<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;
use Carbon\Carbon;

class MembersTableSeeder extends Seeder
{
    public function run()
    {
        $members = [
            [
                'first_name' => 'Juan',
                'last_name' => 'Dela Cruz',
                'email' => 'juan@church.com',
                'phone' => '09123456789',
                'address' => 'Manila',
                'joined_date' => Carbon::now(),
            ],
            [
                'first_name' => 'Maria',
                'last_name' => 'Santos',
                'email' => 'maria@church.com',
                'phone' => '09234567890',
                'address' => 'Quezon City',
                'joined_date' => Carbon::now(),
            ],
            [
                'first_name' => 'Jose',
                'last_name' => 'Reyes',
                'email' => 'jose@church.com',
                'phone' => '09345678901',
                'address' => 'Makati',
                'joined_date' => Carbon::now(),
            ],
            [
                'first_name' => 'Ana',
                'last_name' => 'Garcia',
                'email' => 'ana@church.com',
                'phone' => '09456789012',
                'address' => 'Pasig',
                'joined_date' => Carbon::now(),
            ],
            [
                'first_name' => 'Pedro',
                'last_name' => 'Fernandez',
                'email' => 'pedro@church.com',
                'phone' => '09567890123',
                'address' => 'Taguig',
                'joined_date' => Carbon::now(),
            ],
        ];

        foreach ($members as $member) {
            Member::create($member);
        }
        
        $this->command->info('✅ Added 5 members to database!');
    }
}