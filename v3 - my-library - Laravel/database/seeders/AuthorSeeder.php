<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        Author::updateOrCreate(['name' => 'Dante', 'surname' => 'Alighieri'], ['birthYear' => '1265']);
        Author::updateOrCreate(['name' => 'Alessandro', 'surname' => 'Manzoni'], ['birthYear' => '1785']);
        Author::updateOrCreate(['name' => 'Italo', 'surname' => 'Calvino'], ['birthYear' => '1923']);
    }
}