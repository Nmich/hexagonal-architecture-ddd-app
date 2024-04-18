<?php

namespace App\Domain\Map;

final class Marker
{
    public function __construct(
        public readonly string $id,
        private Name $name,
        private Location $location,
    ) {
    }
}
