<?php

namespace App\Domain\Cartographer;

class Cartographer
{
    public function __construct(
        private readonly string $id,
        private Username $username,
        private string $password,
    ) {
    }

    public static function whatever(
        string $id = '0cfc162d-77ee-4ba4-ad90-c5af12eb0af8',
        string $username = 'arn0',
        string $password = 'password',
    ): self {
        return new self($id, new Username($username), $password);
    }

    public static function register(
        string $id,
        string $username,
        string $password,
        PasswordEncryptor $passwordEncryptor,
    ): self {
        return new self($id, new Username($username), Password::fromString($password, $passwordEncryptor));
    }

    public function equal(string $id): bool
    {
        return $this->id === $id;
    }
}
