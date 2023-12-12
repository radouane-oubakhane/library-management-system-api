<?php

namespace Database\Seeders;

use App\Models\BookCopy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookCopySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BookCopy::factory()->count(10)->create();
    }
}
