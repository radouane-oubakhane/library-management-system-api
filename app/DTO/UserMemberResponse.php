<?php

namespace App\DTO;

use App\Models\Member;

class UserMemberResponse
{
    public function __construct(
        public Member $member,
        public array  $bookCopies,
    ) {
    }

}
