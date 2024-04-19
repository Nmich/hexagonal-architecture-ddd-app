<?php

namespace App\Domain\Cartographer;

class Password
{
    public function __construct(private readonly string $hash)
    {
    }

    public static function fromString(string $password, PasswordEncryptor $passwordEncryptor): self
    {
        if (1 !== \preg_match('#(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}#', $password)) {
            throw new \InvalidArgumentException('The password must contain at least 8 characters an uppercase letter, lowercase letter and a number');
        }

        return new self($passwordEncryptor->encrypt($password));
    }

    public static function fromHash(string $hash): self
    {
        return new self($hash);
    }

    public function __toString(): string
    {
        return $this->hash;
    }
}
