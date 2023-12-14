<?php

namespace App\DTO\profile\memberProfile;


class MemberProfileReservationResponse
{
    public function __construct(
        public int                   $id,
        public MemberProfileBookResponse   $book,
        public string                $reserved_at,
        public ?string               $canceled_at,
        public ?string               $expired_at,
        public string                $status,
    ) {
    }
}
