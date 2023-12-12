<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Borrow>
 */
class BorrowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_id' => Book::factory(),
            'book_copy_id' => BookCopy::factory(),
            'member_id' => Member::factory(),
            'borrow_date' => $this->faker->date,
            'return_date' => $this->faker->date,
            'status' => $this->faker->randomElement(['borrowed', 'returned']),
        ];
    }
}
