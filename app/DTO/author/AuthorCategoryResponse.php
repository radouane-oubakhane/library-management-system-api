<?php

namespace App\DTO\author;

class AuthorCategoryResponse
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }

}
