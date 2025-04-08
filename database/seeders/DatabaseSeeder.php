<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Créer les rôles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Créer les permissions
        $createServerPermission = Permission::create(['name' => 'create server']);
        $manageServerPermission = Permission::create(['name' => 'manage server']);

        // Attribuer les permissions aux rôles
        $adminRole->givePermissionTo([$createServerPermission, $manageServerPermission]);
        $userRole->givePermissionTo($createServerPermission);

        // Créer un utilisateur admin
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);
        $admin->assignRole($adminRole);

        // Créer un utilisateur normal
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        $user->assignRole($userRole);
    }
}
