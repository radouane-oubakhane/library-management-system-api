<?php

namespace App\DTO\borrow;

class BorrowCategoryResponse
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }

}
