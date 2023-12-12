<?php

namespace App\DTO;

class BookCopyResponse
{
    public function __construct(
        public int $id,
        public string $book_title,
        public string $book_author_first_name,
        public string $book_author_last_name,
        public string $book_category_name,
        public int $book_stock,
        public int $reservation_count,
        public int $borrow_count,
        public int $available_count,
    ) {
    }
}
