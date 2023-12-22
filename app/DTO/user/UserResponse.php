<?php

namespace App\DTO\user;

class UserResponse
{
    public function __construct(
        public int $id,
        public string $email,
        public bool $is_admin,
        public string $first_name,
        public string $last_name,
        public string $picture,
        public string $member_id,
    ) {
    }

}
