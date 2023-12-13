<?php

namespace App\DTO\user;

class UserResponse
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $role,
    ) {
    }

}
