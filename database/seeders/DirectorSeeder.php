<?php

namespace Database\Seeders;

use App\Models\Director;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DirectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test company first if it doesn't exist
        $company = Company::firstOrCreate(
            ['name' => 'Test Fleet Company'],
            [
                'email' => 'company@example.com',
                'phone' => '+1234567890',
                'address' => '123 Fleet Street, City, State 12345'
            ]
        );

        // Create a default director for testing
        Director::firstOrCreate(
            ['email' => 'director@example.com'],
            [
                'name' => 'Test Director',
                'phone' => '+1234567890',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'company_id' => $company->id,
            ]
        );

        // Create additional test directors
        Director::factory()
            ->count(5)
            ->for($company)
            ->create();

        $this->command->info('Directors seeded successfully!');
        $this->command->info('Test Director Login: director@example.com / password');
    }
}
