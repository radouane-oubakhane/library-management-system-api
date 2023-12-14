<?php

namespace App\DTO\inscription;

class InscriptionResponse
{
   public function __construct(
        public int $id,
        public string $first_name,
        public string $last_name,
        public string $email,
        public string $phone,
        public string $address,
        public string $date_of_birth,
        public string $status,
        public string $picture,
    ) {
    }

}
