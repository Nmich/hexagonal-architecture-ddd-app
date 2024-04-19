<?php

namespace App\Domain\Map;

interface MarkerLocationDatabaseClient
{
    public function send(
        string $markerId,
        string $name,
        float $latitude,
        float $longitude
    ): void;
}
