<?php

namespace App\Infra\Clock;

use App\Domain\Clock;

final class InMemoryClock implements Clock
{
    private \DateTimeImmutable $now;

    public function __construct(string $now = 'now')
    {
        $this->now = new \DateTimeImmutable($now);
    }

    public function now(): \DateTimeImmutable
    {
        return $this->now;
    }
}

