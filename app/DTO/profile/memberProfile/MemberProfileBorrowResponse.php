<?php

namespace App\DTO\profile\memberProfile;

class MemberProfileBorrowResponse
{
    public function __construct(
        public int                         $id,
        public MemberProfileBookResponse   $book,
        public string                      $borrow_date,
        public string                      $return_date,
        public string                      $status,
    ) {
    }
}
