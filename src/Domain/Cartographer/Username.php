<?php

namespace App\Domain\Cartographer;

class Username
{
    public function __construct(private readonly string $username)
    {
        if (strlen($username) < 3) {
            throw new \InvalidArgumentException('The username should contain 3 at least characters');
        }
    }

    public function __toString(): string
    {
        return $this->username;
    }
}
