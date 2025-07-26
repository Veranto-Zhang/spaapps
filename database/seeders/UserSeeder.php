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
            ['name' => 'Office', 'email' => 'office@admin.com', 'password' => 'password'],
            ['name' => 'Spa', 'email' => 'spa@admin.com', 'password' => 'securepassword'],
            ['name' => 'Admin', 'email' => 'admin@admin.com', 'password' => 'admin123'],
            ['name' => 'SuperAdmin', 'email' => 'super@admin.com', 'password' => 'admin123'],
        ];
        
        foreach ($users as $userData) {
            User::firstOrCreate(
                ['email' => $userData['email']],
                ['name' => $userData['name'], 'password' => bcrypt($userData['password'])]
            );
        }




    }
}
