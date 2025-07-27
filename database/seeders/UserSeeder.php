<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // $user = User::create([
        //     'name' => 'Super Admin',
        //     'email' => 'super@admin.com',
        //     'password' => bcrypt('password123')
        // ]);

        $users = [
            ['name' => 'Office', 'email' => 'office@admin.com', 'password' => 'BintanHoliday'],
            ['name' => 'Spa', 'email' => 'spa@admin.com', 'password' => 'PeonyLounge'],
            ['name' => 'Pak Andri & Bu Susi', 'email' => 'owner@admin.com', 'password' => 'STAT0808'],
            ['name' => 'SuperAdmin', 'email' => 'super@admin.com', 'password' => 'zwlspace123'],
        ];
        
        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                ['name' => $userData['name'], 'password' => bcrypt($userData['password'])]
            );
        }




    }
}
