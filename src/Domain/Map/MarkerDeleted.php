<?php

declare(strict_types=1);

namespace App\Domain\Map;

final class MarkerDeleted
{
    public function __construct(
        private readonly string $id,
    ) {
    }
}
