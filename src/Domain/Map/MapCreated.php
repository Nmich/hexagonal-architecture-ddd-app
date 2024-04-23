<?php

declare(strict_types=1);

namespace App\Domain\Map;

final class MapCreated
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
    ) {
    }
}
