<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
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
            'member_id' => Member::factory(),
            'reserved_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'canceled_at' => $this->faker->optional()->dateTimeBetween('now', '+5 days'),
            'expired_at' => $this->faker->dateTimeBetween('now', '+1 week'),
            'status' => $this->faker->randomElement(['reserved', 'canceled', 'expired', 'borrowed']),
        ];
    }
}
