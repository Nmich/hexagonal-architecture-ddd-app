<?php

namespace App\Domain\Map;

final class UnknownMap extends \Exception
{
    public static function fromId(string $id): self
    {
        return new self("Map with id '$id' not found");
    }
}
