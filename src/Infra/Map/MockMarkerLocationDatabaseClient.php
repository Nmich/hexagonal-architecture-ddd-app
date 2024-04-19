<?php

namespace App\Infra\Map;

use App\Domain\Map\MarkerLocationDatabaseClient;

final class MockMarkerLocationDatabaseClient implements MarkerLocationDatabaseClient
{
    private string $markerId = '';
    private string $name = '';
    private float $latitude = 0.0;
    private float $longitude = 0.0;

    public function send(
        string $markerId,
        string $name,
        float $latitude,
        float $longitude
    ): void {
        $this->markerId = $markerId;
        $this->name = $name;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function isCalledWith(string $markerId, string $name, float $latitude, float $longitude): bool
    {
        return $this->markerId === $markerId
            && $this->name === $name
            && $this->latitude === $latitude
            && $this->longitude === $longitude;
    }
}
