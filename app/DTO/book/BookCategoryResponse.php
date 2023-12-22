<?php

namespace App\DTO\book;

class BookCategoryResponse
{
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        public string $picture,
    ) {
    }

}
