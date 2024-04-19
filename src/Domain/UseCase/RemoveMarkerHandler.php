<?php

namespace App\Domain\UseCase;

use App\Domain\Map\UnknownMap;
use App\Infra\Map\InMemoryMaps;

final class RemoveMarkerHandler
{
    public function __construct(private readonly InMemoryMaps $maps)
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
