<?php

namespace App\Domain\Map;

final class Map
{
    public function __construct(
        private readonly string $id,
        private readonly string $name
    ) {
    }

    public function equal(string $id): bool
    {
        return $this->id === $id;
    }
}
