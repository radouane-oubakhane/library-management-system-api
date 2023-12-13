<?php

namespace App\DTO\reservation;

class ReservationResponse
{
    public function __construct(
        public int $id,
        public ReservationMemberResponse $member,
        public ReservationBookResponse $book,
        public string $reserved_at,
        public ?string $canceled_at,
        public ?string $expired_at,
        public string $status,
    ) {
    }
}
