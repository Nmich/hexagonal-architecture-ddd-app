<?php

namespace App\Domain\Cartographer;

interface PasswordEncryptor
{
    public function encrypt(string $password): string;
}
