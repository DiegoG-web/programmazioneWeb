<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Author;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $authors = Author::all();

        // Crea 5 libri totali usando la factory e assegnando autori reali
        foreach (range(1, 5) as $index) {
            Book::factory()->create([
                'author_id' => $authors->random()->id
            ]);
        }
    }
}