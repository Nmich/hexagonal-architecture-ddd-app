<?php

namespace App\Infra\Map;

use App\Domain\Map\Map;
use App\Domain\Map\Maps;
use App\Domain\Map\UnknownMap;

final class InMemoryMaps implements Maps
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
