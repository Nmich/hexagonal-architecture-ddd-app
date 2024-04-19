<?php

namespace App\Domain\UseCase;

final class RegisterCartographer
{
    public function __construct(
        public string $id = '',
        public string $username = '',
        public string $password = '',
    ) {
    }
}
