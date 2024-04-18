<?php

namespace App\Domain\Map;

final class Name
{
    public function __construct(
        private readonly string $name,
    ) {
        if (empty($name)) {
            throw new \InvalidArgumentException('Name cannot be empty');
        }
    }
}
