<?php

namespace App\DTO\category;

class CategoryResponse
{
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        public string $picture,
    ) {
    }

}
