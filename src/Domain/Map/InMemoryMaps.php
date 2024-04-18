<?php

namespace App\Domain\Map;

final class InMemoryMaps
{
    public function __construct(private array $maps = [])
    {
    }

    public function add(Map $map): void
    {
        $this->maps[] = $map;
    }

    public function get(string $id): Map
    {
        if (!$map = current(array_filter($this->maps, fn (Map $map) => $map->equal($id)))) {
            throw UnknownMap::fromId($id);
        }

        return $map;
    }
}
