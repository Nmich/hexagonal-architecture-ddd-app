<?php

declare(strict_types=1);

namespace App\Domain\Map;

final class MarkerAdded
{
    public function __construct(
        private readonly string $id,
        private readonly Name $name,
        private readonly Location $location,
    ) {
    }
}
