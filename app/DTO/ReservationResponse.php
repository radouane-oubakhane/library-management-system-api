<?php

namespace App\DTO;

class ReservationResponse
{
    public function __construct(
        public string $id,
        public string $book_title,
        public string $book_isbn,
        public string $member_first_name,
        public string $member_last_name,
        public string $reserved_at,
        public string $canceled_at,
        public string $expired_at,
    ) {
    }
}
