<?php

namespace App\Infra\Map;

use App\Domain\Map\MarkerLocationDatabaseClient;

final class DummyMarkerLocationDatabaseClient implements MarkerLocationDatabaseClient
{
    public function send(
        string $markerId,
        string $name,
        float $latitude,
        float $longitude
    ): void {}
}
