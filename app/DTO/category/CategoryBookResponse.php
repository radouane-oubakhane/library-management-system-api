<?php

namespace App\DTO\category;

use App\DTO\author\AuthorCategoryResponse;
use App\DTO\category\CategoryResponse;

class CategoryBookResponse
{
    public function __construct(
        public int $id,
        public string $title,
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

