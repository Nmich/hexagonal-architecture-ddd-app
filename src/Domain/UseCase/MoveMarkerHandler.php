<?php

namespace App\Domain\UseCase;

use App\Domain\Map\Maps;
use App\Domain\Map\UnknownMap;

final class MoveMarkerHandler
{
    public function __construct(private readonly Maps $maps)
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
