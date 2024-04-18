<?php

namespace App\Domain\UseCase;

final class MoveMarker
{
    public function __construct(
        public readonly string $mapId,
        public readonly string $markerId,
        public readonly float $latitude,
        public readonly float $longitude,
    ) {
    }
}
