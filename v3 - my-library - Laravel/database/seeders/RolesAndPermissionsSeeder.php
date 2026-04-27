<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Svuota la cache di Spatie
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Creazione dei Permessi per la LIBRERIA
        //Permission::create(['name' => 'view books']);
        Permission::create(['name' => 'book_edit']);
        Permission::create(['name' => 'book_delete']);
        Permission::create(['name' => 'book_read']);

        // 3. Ruolo Utente Base (può solo vedere i libri)
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo('view_books');

        // 5. Ruolo Amministratore (ha tutti i poteri)
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());
    }
}