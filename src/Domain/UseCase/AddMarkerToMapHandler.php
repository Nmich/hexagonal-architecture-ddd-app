<?php

namespace App\Domain\UseCase;

use App\Domain\Clock;
use App\Domain\Map\Maps;
use App\Domain\Map\MarkerLocationDatabaseClient;
use App\Domain\Map\UnknownMap;

final class AddMarkerToMapHandler
{
    public function __construct(
        private readonly Maps $maps,
        private MarkerLocationDatabaseClient $markerLocationDatabaseClient,
        private Clock $clock
    ) {
    }

    /**
     * @throws UnknownMap
     */
    public function __invoke(AddMarkerToMap $addMarkerToMap): void
    {
        $map = $this->maps->get($addMarkerToMap->mapId);
        $map->addMarker(
            $addMarkerToMap->markerId,
            $addMarkerToMap->name,
            $addMarkerToMap->latitude,
            $addMarkerToMap->longitude,
            $this->clock->now(),
        );

        $this->markerLocationDatabaseClient->send(
            $addMarkerToMap->markerId,
            $addMarkerToMap->name,
            $addMarkerToMap->latitude,
            $addMarkerToMap->longitude
        );

        $this->maps->add($map);
    }
}
