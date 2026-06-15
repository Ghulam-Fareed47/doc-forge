<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Check if admin already exists
        if (!User::where('email', 'admin@pdfmerger.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@pdfmerger.com',
                'password' => Hash::make('12341234'),
                'email_verified_at' => now(),
                'is_admin' => true,
            ]);
            $this->command->info('Admin user created: admin@pdfmerger.com / password');
        } else {
            // Update existing admin to ensure is_admin is true
            User::where('email', 'admin@pdfmerger.com')->update(['is_admin' => true]);
            $this->command->info('Admin user already exists. Updated is_admin to true.');
        }
    }
}
