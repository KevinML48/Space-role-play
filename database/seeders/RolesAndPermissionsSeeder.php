<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Création des rôles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        // Création admin par défaut
        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
        ])->assignRole('admin');
    }
}
