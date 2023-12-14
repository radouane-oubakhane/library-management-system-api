<?php

namespace App\DTO\author;

use App\DTO\category\CategoryResponse;

class AuthorBookResponse
{
    public function __construct(
        public int $id,
        public string $title,
        public AuthorCategoryResponse $category,
        public string $isbn,
        public string $description,
        public int $stock,
        public string $publisher,
        public string $published_at,
        public string $language,
        public string $edition,
        public string $picture,
    ) {}
}

