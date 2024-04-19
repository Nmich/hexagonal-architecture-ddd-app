<?php

namespace App\Infra\Cartographer;

use App\Domain\Cartographer\PasswordEncryptor;

final class BcryptPasswordEncryptor implements PasswordEncryptor
{
    public function encrypt(string $password): string
    {
        return \password_hash($password, PASSWORD_BCRYPT);
    }
}
