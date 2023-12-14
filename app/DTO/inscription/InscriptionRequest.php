<?php

namespace App\DTO\inscription;

class InscriptionRequest
{
   public function __construct(
        public string $first_name,
        public string $last_name,
        public string $email,
        public string $phone,
        public string $address,
        public string $date_of_birth,
        public string $status,
        public string $password,
        public string $picture,
    ) {
    }

}
