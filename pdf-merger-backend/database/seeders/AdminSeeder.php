<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if admin already exists
        if (!User::where('email', 'admin@pdfmerger.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@pdfmerger.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
            $this->command->info('Admin user created: admin@pdfmerger.com / password');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}
