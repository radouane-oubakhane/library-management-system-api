<?php

namespace App\DTO\borrow;

class BorrowResponse
{
    public function __construct(
        public int $id,
        public BorrowBookResponse $book,
        public int $book_copy_id,
        public BorrowMemberResponse $member,
        public string $borrow_date,
        public string $return_date,
        public string $status,
    ) {
    }
}
