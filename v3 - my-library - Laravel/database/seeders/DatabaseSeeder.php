<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Esegui il seeder dei Ruoli
        $this->call(RolesAndPermissionsSeeder::class);

        // 2. Crea gli Utenti e assegna i ruoli
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);
        $user->assignRole('user');

        // 3. Esegui il seeder degli Autori
        $this->call(AuthorSeeder::class);

        // 4. Esegui il seeder dei Libri
        $this->call(BookSeeder::class);
    }
}