<?php

namespace App\Domain\UseCase;

final class AddMarkerToMap
{
    public function __construct(
        public readonly string $mapId,
        public readonly string $markerId,
        public readonly string $name,
        public readonly float $latitude,
        public readonly float $longitude,
    ) {
    }
}
