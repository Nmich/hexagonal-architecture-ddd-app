<?php

namespace App\Domain\UseCase;

use App\Domain\Map\Maps;
use App\Domain\Map\UnknownMap;

final class RemoveMarkerHandler
{
    public function __construct(private readonly Maps $maps)
    {
    }

    /**
     * @throws UnknownMap
     */
    public function __invoke(RemoveMarker $removeMarker): void
    {
        $map = $this->maps->get($removeMarker->mapId);
        $map->removeMarker(
            $removeMarker->markerId,
        );
        $this->maps->add($map);
    }
}
