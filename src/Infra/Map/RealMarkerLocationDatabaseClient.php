<?php

namespace App\Infra\Map;

use App\Domain\Map\MarkerLocationDatabaseClient;

final class RealMarkerLocationDatabaseClient implements MarkerLocationDatabaseClient
{
    public function send(
        string $markerId,
        string $name,
        float $latitude,
        float $longitude
    ): void {
        // Appel du vrai service pour envoyer les données sur le service tier
    }
}
