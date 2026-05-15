<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Book;
use App\Models\Author;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(10),
            'price' => fake()->randomFloat(2, 5, 100),
            'year' => fake()->numberBetween(1990, date('Y')),
            // IMPORTANT: ensures referential integrity
            // 'author_id' => Author::factory(),
            'author_id' => 1,
        ];
    }
}