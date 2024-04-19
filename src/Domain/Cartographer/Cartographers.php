<?php

namespace App\Domain\Cartographer;

use LogicException;

interface Cartographers
{
    /**
     * @throws LogicException
     */
    public function add(Cartographer $cartographer): void;

    /**
     * @throws LogicException
     * @throws UnknownCartographer
     */
    public function get(string $id): Cartographer;
}
