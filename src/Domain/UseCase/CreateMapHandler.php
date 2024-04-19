<?php

namespace App\Domain\UseCase;

use App\Domain\Map\Map;
use App\Domain\Map\Maps;

final class CreateMapHandler
{
    public function __construct(private readonly Maps $maps)
    {
    }

    public function __invoke(CreateMap $createMap): void
    {
        $this->maps->add(Map::create($createMap->id, $createMap->name));
    }
}
