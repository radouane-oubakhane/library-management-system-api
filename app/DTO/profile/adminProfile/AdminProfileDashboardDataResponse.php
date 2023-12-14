<?php

namespace App\DTO\profile\adminProfile;

class AdminProfileDashboardDataResponse
{
    public function __construct(
        public int $booksCount,
        public int $authorsCount,
        public int $categoriesCount,
        public int $membersCount,
        public int $reservationsCount,
        public int $borrowsCount,
        public int $inscriptionsCount
    ) {
    }
}
