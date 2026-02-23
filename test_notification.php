<?php

require __DIR__ . '/vendor/autoload.php';

use App\Models\User;
use App\Notifications\NewUserRegisteredNotification;

try {
    // Load Laravel
    $app = require __DIR__ . '/bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

    // Find admin user
    $admin = User::where('role', 'admin')->first();
    
    if (!$admin) {
        echo "❌ No admin user found!\n";
        exit(1);
    }

    echo "✅ Found admin user: " . $admin->name . "\n";

    // Create a test user or use an existing one
    $testUser = User::where('email', 'test@example.com')->first();
    if (!$testUser) {
        $testUser = User::create([
            'name' => 'Test User ' . time(),
            'email' => 'test' . time() . '@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
        echo "✅ Created test user: " . $testUser->name . "\n";
    } else {
        echo "✅ Using existing test user: " . $testUser->name . "\n";
    }

    // Send notification
    echo "\n📤 Sending notification...\n";
    $admin->notify(new NewUserRegisteredNotification($testUser));
    
    echo "✅ Notification sent successfully!\n";
    echo "\n📋 Next steps:\n";
    echo "1. Make sure Reverb server is running: php artisan reverb:start\n";
    echo "2. Open admin dashboard in browser\n";
    echo "3. Check browser console for debug logs\n";
    echo "4. You should see a toast notification when it arrives\n";

} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
