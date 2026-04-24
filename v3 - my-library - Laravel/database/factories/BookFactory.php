<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
        protected $model = Book::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(10),
            'price' => $this->faker->randomFloat(2, 10, 100),
            'year' => $this->faker->year,
            'author_id' =>1,
            //AuthorFactory::factory(),
        ];
    }
}
