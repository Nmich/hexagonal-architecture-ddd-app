<?php

namespace App\Domain\Cartographer;

class Cartographer
{
    public function __construct(
        private readonly string $id,
        private Username $username,
        private Password $password,
        private array $events = [],
    ) {
    }

    public static function whatever(
        string $id = '0cfc162d-77ee-4ba4-ad90-c5af12eb0af8',
        string $username = 'arn0',
        string $password = '$2a$12$pTBZuTRRWbdtQ8VPaZSzOe.PNebOr/yDNZvU6tq0R/XzX9l5fWDlS',
        array $events = [],
    ): self {
        return new self($id, new Username($username), Password::fromHash($password), $events);
    }

    public static function register(
        string $id,
        string $username,
        string $password,
        PasswordEncryptor $passwordEncryptor,
    ): self {
        $username = new Username($username);

        return new self(
            $id,
            $username,
            Password::fromString($password, $passwordEncryptor),
            [new CartographerRegistered($id, $username)]
        );
    }

    public function equal(string $id): bool
    {
        return $this->id === $id;
    }
}
