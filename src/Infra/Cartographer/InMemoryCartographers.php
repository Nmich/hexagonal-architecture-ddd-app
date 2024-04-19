<?php

namespace App\Infra\Cartographer;

use App\Domain\Cartographer\Cartographer;
use App\Domain\Cartographer\Cartographers;
use App\Domain\Cartographer\UnknownCartographer;

final class InMemoryCartographers implements Cartographers
{
    public function __construct(private array $cartographers = [])
    {
    }

    public function add(Cartographer $cartographer): void
    {
        $this->cartographers[] = $cartographer;
    }

    public function get(string $id): Cartographer
    {
        if (!$cartographer = current(
            array_filter($this->cartographers, fn (Cartographer $cartographer) => $cartographer->equal($id)))
        ) {
            throw UnknownCartographer::fromId($id);
        }

        return $cartographer;
    }
}
