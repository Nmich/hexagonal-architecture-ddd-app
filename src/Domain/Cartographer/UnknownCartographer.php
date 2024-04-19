<?php

namespace App\Domain\Cartographer;

use App\Domain\Map\Command\Id;

final class UnknownCartographer extends \Exception
{
    public static function fromId(string $id): self
    {
        return new self("Cartographer with id '$id' not found");
    }
}
