<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $menuItems = config('menu.items');

        // Stop if config not found
        if (!$menuItems) {
            $this->command->info('No menu items found in config/menu.php');
            return;
        }

        $allPermissions = [];

        // Create permissions
        foreach ($menuItems as $item) {
            if (isset($item['permissions']) && is_array($item['permissions'])) {
                foreach ($item['permissions'] as $permission) {
                    $perm = Permission::firstOrCreate([
                        'name' => $permission,
                        'guard_name' => 'web'
                    ]);
                    $allPermissions[] = $perm->name;
                }
            }
        }

        $this->command->info('All permissions created.');

        // Create Admin role if not exists
        $adminRole = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web'
        ]);

        // Assign all permissions to Admin
        $adminRole->syncPermissions($allPermissions);

        $this->command->info('Admin role assigned with all permissions.');
    }
}
