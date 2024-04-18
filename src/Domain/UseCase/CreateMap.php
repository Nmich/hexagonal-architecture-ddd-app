<?php

namespace App\Domain\UseCase;

final class CreateMap
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
    ) {
    }
}
