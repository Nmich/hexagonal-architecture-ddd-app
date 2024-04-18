<?php

namespace App\Domain\UseCase;

final class RemoveMarker
{
    public function __construct(
        public readonly string $mapId,
        public readonly string $markerId,
    ) {
    }
}
