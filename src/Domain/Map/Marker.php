<?php

namespace App\Domain\Map;

final class Marker
{
    public function __construct(
        public readonly string $id,
        private Name $name,
        private Location $location,
        private \DateTimeImmutable $addedAt,
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
        string $addedAt = '2021-01-01 00:00:00',
    ): self {
        return new self($id, new Name($name), new Location($latitude, $longitude), new \DateTimeImmutable($addedAt));
    }

    /**
     * Using an ORM is not the only way to persist data.
     * Have a look at https://arnolanglade.github.io/persisting-entities-without-orm.html.
     */
    public static function fromState(MarkerState $markerState): self
    {
        return new self(
            $markerState->markerId,
            new Name($markerState->name),
            new Location($markerState->latitude, $markerState->longitude),
            $markerState->addedAt,
        );
    }

    public function move(float $latitude, float $longitude): void
    {
        $this->location = new Location($latitude, $longitude);
    }

    public function mapTo(MarkerState $doctrineMarker): MarkerState
    {
        list($latitude, $longitude) = $this->location->toState();
        $doctrineMarker->markerId = $this->id;
        $doctrineMarker->name = (string) $this->name;
        $doctrineMarker->latitude = $latitude;
        $doctrineMarker->longitude = $longitude;
        $doctrineMarker->addedAt = $this->addedAt;

        return $doctrineMarker;
    }


    public function equal(string $id): bool
    {
        return $this->id === $id;
    }
}
