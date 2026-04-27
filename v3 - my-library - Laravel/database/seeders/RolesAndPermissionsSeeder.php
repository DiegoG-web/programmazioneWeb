<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Reset cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Crea i permessi e SALVALI in variabili
        $edit = Permission::findOrCreate('edit_book', 'web');
        $delete = Permission::findOrCreate('delete_book', 'web');
        $read = Permission::findOrCreate('read_book', 'web');

        // 3. Crea i ruoli
        $userRole = Role::findOrCreate('user', 'web');
        $adminRole = Role::findOrCreate('admin', 'web');

        // 4. Assegna i permessi usando le variabili (così siamo sicuri che esistano)
        $userRole->givePermissionTo($read);

        // L'admin prende tutto
        $adminRole->givePermissionTo([$edit, $delete, $read]);
    }
}