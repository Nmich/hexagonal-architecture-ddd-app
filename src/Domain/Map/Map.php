<?php

namespace App\Domain\Map;

final class Map
{
    public function __construct(
        public readonly string $id,
        private readonly Name $name,
        private MarkerList $markers,
        private array $events = [],
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
        string $name = 'Bon plan',
        array $markers = [],
        array $events = [],
    ): self {
        return new self($id, new Name($name), MarkerList::fromArray($markers), $events);
    }
    /**
     * Using an ORM is not the only way to persist data.
     * Have a look at https://arnolanglade.github.io/persisting-entities-without-orm.html.
     */
    public static function fromState(MapState $mapState): self
    {
        $markers = $mapState->markers->map(
            fn (MarkerState $marker) => Marker::fromState($marker)
        );

        return new self(
            $mapState->mapId,
            new Name($mapState->name),
            MarkerList::fromArray($markers->toArray())
        );
    }

    public static function create(string $id, string $name): self
    {
        return new self($id, new Name($name), MarkerList::empty(), [new MapCreated($id, $name)]);
    }

    public function addMarker(string $markerId, string $name, float $latitude, float $longitude, \DateTimeImmutable $addedAt): void
    {
        $name = new Name($name);
        $location = new Location($latitude, $longitude);

        $this->markers = $this->markers->add(
            new Marker($markerId, $name, new Location($latitude, $longitude), $addedAt)
        );

        $this->events[] = new MarkerAdded($markerId, $name, $location);
    }

    public function moveMarker(string $markerId, float $latitude, float $longitude): void
    {
        $this->markers = $this->markers->update(
            $markerId,
            function (Marker $marker) use ($longitude, $latitude, $markerId) {
                $marker->move($latitude, $longitude);
                $this->events[] = new MarkerMoved($markerId, new Location($latitude, $longitude));

                return $marker;
            }
        );
    }

    public function removeMarker(string $markerId): void
    {
        $this->markers = $this->markers->remove($markerId);
        $this->events[] = new MarkerDeleted($markerId);
    }


    public function mapTo(MapState $mapState): void
    {
        $mapState->mapId = $this->id;
        $mapState->name = $this->name;

        $this->markers->mapTo($mapState);
    }

    public function equal(string $id): bool
    {
        return $this->id === $id;
    }
}
