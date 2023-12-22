<?php

namespace App\DTO\author;


class AuthorResponse
{
    public function __construct(
        public int $id,
        public string $first_name,
        public string $last_name,
        public string $email,
        public string $phone,
        public string $address,
        public string $date_of_birth,
        public string $biography,
        public string $picture,
    ) {
    }
}
