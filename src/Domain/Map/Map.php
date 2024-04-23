<?php

namespace App\Domain\Map;

final class Map
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private array $events = [],
    ) {
    }

    public static function create(string $id, string $name): self
    {
        return new self($id, $name, [new MapCreated($id, $name)]);
    }

    public function equal(string $id): bool
    {
        return $this->id === $id;
    }
}
