<?php

declare(strict_types=1);

namespace App\Domain\Cartographer;

final class CartographerRegistered
{
    public function __construct(
        private readonly string   $id,
        private readonly Username $username,
    ) {
    }
}
