<?php

namespace App\Domain\Map;

final class Location
{
    public function __construct(
        private readonly float $latitude,
        private readonly float $longitude,
    ) {
        if (90 < $latitude || -90 > $latitude) {
            throw new \OutOfRangeException('The latitude must be between -90 and 90');
        }

        if (180 < $longitude || -180 > $longitude) {
            throw new \OutOfRangeException('The latitude must be between -180 and 180');
        }
    }

    /**
     * @return array{0: float, 1: float}
     */
    public function toState(): array
    {
        return [$this->latitude, $this->longitude];
    }
}
