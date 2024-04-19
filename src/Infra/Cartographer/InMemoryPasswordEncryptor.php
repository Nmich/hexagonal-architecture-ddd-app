<?php

namespace App\Infra\Cartographer;

use App\Domain\Cartographer\PasswordEncryptor;

final class InMemoryPasswordEncryptor implements PasswordEncryptor
{
    public function encrypt(string $password): string
    {
        return '$2a$12$pTBZuTRRWbdtQ8VPaZSzOe.PNebOr/yDNZvU6tq0R/XzX9l5fWDlS';
    }
}
