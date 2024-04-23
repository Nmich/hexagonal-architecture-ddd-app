<?php

declare(strict_types=1);

namespace App\Domain\Map;

final class MarkerMoved
{
    public function __construct(
        private readonly string $id,
        private readonly Location $newLocation,
    ) {
    }
}
