<?php

namespace App\DTO;

class BorrowResponse
{
    public function __construct(
        public string $id,
        public string $book_title,
        public string $book_isbn,
        public string $book_copy_id,
        public string $member_first_name,
        public string $member_last_name,
        public string $borrow_date,
        public string $return_date,
        public string $status,
    ) {
    }

}
