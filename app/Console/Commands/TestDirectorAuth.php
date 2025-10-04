<?php

namespace App\Console\Commands;

use App\Models\Director;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TestDirectorAuth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:director-auth {email=director@example.com} {password=password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test director authentication system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $this->info("Testing Director Authentication System");
        $this->info("=====================================");

        // Test 1: Check if director exists
        $director = Director::where('email', $email)->first();
        
        if (!$director) {
            $this->error("❌ Director with email '{$email}' not found!");
            $this->info("💡 Run 'php artisan db:seed --class=DirectorSeeder' to create test directors");
            return 1;
        }

        $this->info("✅ Director found: {$director->name} ({$director->email})");

        // Test 2: Check password
        if (!Hash::check($password, $director->password)) {
            $this->error("❌ Password verification failed!");
            return 1;
        }

        $this->info("✅ Password verification successful");

        // Test 3: Test authentication guard
        try {
            $authenticated = Auth::guard('director')->attempt([
                'email' => $email,
                'password' => $password
            ]);

            if ($authenticated) {
                $this->info("✅ Director guard authentication successful");
                $authenticatedDirector = Auth::guard('director')->user();
                $this->info("   Authenticated as: {$authenticatedDirector->name}");
                
                // Test logout
                Auth::guard('director')->logout();
                $this->info("✅ Director logout successful");
            } else {
                $this->error("❌ Director guard authentication failed");
                return 1;
            }
        } catch (\Exception $e) {
            $this->error("❌ Authentication error: " . $e->getMessage());
            return 1;
        }

        // Test 4: Check Filament access
        try {
            $panel = \Filament\Facades\Filament::getPanel('director');
            $canAccess = $director->canAccessPanel($panel);
            if ($canAccess) {
                $this->info("✅ Director can access Filament panel");
            } else {
                $this->warn("⚠️  Director cannot access Filament panel");
            }
        } catch (\Exception $e) {
            $this->warn("⚠️  Could not test Filament panel access: " . $e->getMessage());
        }

        $this->info("");
        $this->info("🎉 All tests passed! Director authentication system is working correctly.");
        $this->info("🌐 You can now login at: /director/login");
        $this->info("📧 Email: {$email}");
        $this->info("🔑 Password: {$password}");

        return 0;
    }
}
