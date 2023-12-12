<?php

namespace App\DTO;

class UserBookCopyResponse
{
    public function __construct(
        public int $id,
        public string $book_title,
        public string $book_author_first_name,
        public string $book_author_last_name,
        public string $book_category_name,
        public string $borrow_date,
        public string $return_date,
        public string $status,
    ) {
    }
}
