<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\BookCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'author_id' => Author::factory(),
            'book_category_id' => BookCategory::factory(),
            'isbn' => $this->faker->isbn13(),
            'description' => $this->faker->paragraph,
            'stock' => $this->faker->numberBetween(1, 100),
            'publisher' => $this->faker->company,
            'published_at' => $this->faker->date,
            'language' => $this->faker->languageCode,
            'edition' => $this->faker->numberBetween(1, 10),
            'picture' => $this->faker->imageUrl(),
        ];
    }
}
