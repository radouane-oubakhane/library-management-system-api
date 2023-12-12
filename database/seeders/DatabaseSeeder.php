<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\BookCopy;
use App\Models\Borrow;
use App\Models\Member;
use App\Models\Reservation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // create 10 authors
        $authors = Author::factory()->count(10)->create();

        // create 10 book categories
        $book_categories = BookCategory::factory()->count(10)->create();

        // create 1 book for each author
        $books = $authors->each(function ($author) use ($book_categories) {
            Book::factory()->create([
                'author_id' => $author->id,
                'book_category_id' => $book_categories->random()->id,
            ]);
        });

        // create 10 book copies for each book
        $books->each(function ($book) {
            BookCopy::factory()->count(10)->create([
                'book_id' => $book->id,
            ]);
        });

        // create 10 members
        $members = Member::factory()->count(10)->create();

        // create 10 borrows for each member
        $members->each(function ($member) {
            Borrow::factory()->count(10)->create([
                'member_id' => $member->id,
                'book_id' => BookCopy::all()->random()->book_id,
                'book_copy_id' => BookCopy::all()->random()->id,
            ]);
        });

        // create 10 reservations for each member
        $members->each(function ($member) {
            Reservation::factory()->count(10)->create([
                'member_id' => $member->id,
                'book_id' => BookCopy::all()->random()->book_id,
            ]);
        });


        $this->call([
            InscriptionSeeder::class,
        ]);
    }
}
