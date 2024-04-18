<?php

namespace App\Domain\UseCase;

use App\Domain\Map\InMemoryMaps;
use App\Domain\Map\UnknownMap;

final class MoveMarkerHandler
{
    public function __construct(private readonly InMemoryMaps $maps)
    {
    }

    /**
     * @throws UnknownMap
     */
    public function __invoke(MoveMarker $moveMarker): void
    {
        $map = $this->maps->get($moveMarker->mapId);
        $map->moveMarker(
            $moveMarker->markerId,
            $moveMarker->latitude,
            $moveMarker->longitude,
        );
        $this->maps->add($map);
    }
}
