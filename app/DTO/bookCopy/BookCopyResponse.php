<?php

namespace App\DTO\bookCopy;

class BookCopyResponse
{
    public function __construct(
        public int                  $id,
        public BookCopyBookResponse $book,
        public string               $status,
    ) {}

}
