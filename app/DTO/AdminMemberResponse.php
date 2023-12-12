<?php

namespace App\DTO;

use App\Models\Inscription;
use App\Models\Member;

class AdminMemberResponse
{
    public function __construct(
        public Member $member,
        public Inscription $inscription,
    ) {
    }
}
