<?php

namespace App\DTO\book;

use App\DTO\category\CategoryResponse;

class BookReponse
{
    public function __construct(
        public int $id,
        public string $title,
        public string $author_first_name,
        public string $author_last_name,
        public CategoryResponse $category,
        public string $isbn,
        public string $description,
        public int $stock,
        public string $publisher,
        public string $publish_at,
        public string $language,
        public string $edition,
    ) {}
}

