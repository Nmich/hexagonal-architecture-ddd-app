<?php

namespace App\Domain\Map;

final class Marker
{
    public function __construct(
        private string $id,
        private Name $name,
        private Location $location,
    ) {
    }

    /**
     * Caution: Only for testing purpose!
     * Learn how factories can help you to increase your test quality.
     * Builder pattern is also a good alternative.
     * Have a look at https://arnolanglade.github.io/increase-your-test-quality-thanks-to-builders-or-factories.html.
     */
    public static function whatever(
        string $id = '5a9cc303-b286-4c15-94a1-baefe5aba425',
        string $name = 'Sunset',
        float $latitude = 48.8534,
        float $longitude = 2.3488,
    ): self {
        return new self($id, new Name($name), new Location($latitude, $longitude));
    }

    public function move(float $latitude, float $longitude): void
    {
        $this->location = new Location($latitude, $longitude);
    }


    public function equal(string $id): bool
    {
        return $this->id === $id;
    }
}
