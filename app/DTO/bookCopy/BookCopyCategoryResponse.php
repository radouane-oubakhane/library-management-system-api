<?php

namespace App\DTO\bookCopy;

class BookCopyCategoryResponse
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }

}