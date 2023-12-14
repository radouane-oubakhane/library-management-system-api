<?php

namespace App\DTO\borrow;

class BorrowMemberResponse
{
    public function __construct(
        public int $id,
        public string $first_name,
        public string $last_name,
        public string $email,
        public string $phone,
        public string $address,
        public string $date_of_birth,
        public string $membership_start_date,
        public string $membership_end_date,
        public string $picture,
    ) {
    }
}
