<?php

namespace App\Domain\UseCase;

use App\Domain\Map\InMemoryMaps;
use App\Domain\Map\Map;

final class CreateMapHandler
{
    public function __construct(private readonly InMemoryMaps $maps)
    {
    }

    public function __invoke(CreateMap $createMap): void
    {
        $this->maps->add(new Map($createMap->id, $createMap->name));
    }
}
