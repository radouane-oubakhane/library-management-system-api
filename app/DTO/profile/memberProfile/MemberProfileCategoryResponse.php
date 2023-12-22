<?php

namespace App\DTO\profile\memberProfile;

class MemberProfileCategoryResponse
{
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        public string $picture,
    ) {
    }

}
