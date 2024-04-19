<?php

namespace App\Domain\Map;

use LogicException;

interface Maps
{
    /**
     * @throws LogicException
     */
    public function add(Map $map): void;

    /**
     * @throws LogicException
     * @throws UnknownMap
     */
    public function get(string $id): Map;
}
