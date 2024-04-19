<?php

namespace App\Domain\UseCase;

use App\Domain\Map\Map;
use App\Infra\Map\InMemoryMaps;

final class CreateMapHandler
{
    public function __construct(private readonly InMemoryMaps $maps)
    {
    }

    public function __invoke(CreateMap $createMap): void
    {
        $this->maps->add(Map::create($createMap->id, $createMap->name));
    }
}
