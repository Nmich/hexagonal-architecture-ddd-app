<?php

namespace App\Domain\Map;

final class Map
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        /** @var Marker[] */
        private array $markers = [],
        private array $events = [],
    ) {
    }

    public static function create(string $id, string $name): self
    {
        return new self($id, $name, [], [new MapCreated($id, $name)]);
    }

    public function addMarker(string $markerId, string $name, float $latitude, float $longitude): void
    {
        $this->markers[] = new Marker($markerId, new Name($name), new Location($latitude, $longitude));
    }

    public function equal(string $id): bool
    {
        return $this->id === $id;
    }
}
