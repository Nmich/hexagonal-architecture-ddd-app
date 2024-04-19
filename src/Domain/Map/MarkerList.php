<?php

namespace App\Domain\Map;

final class MarkerList
{
    /** @var Marker[] */
    private readonly array $markers;

    public function __construct(Marker ...$markers)
    {
        $this->markers = $markers;
    }

    /**
     * Do you know what is a primary and a secondary constructor?
     * Have a look at https://arnolanglade.github.io/oop-how-to-build-an-object.html.
     */
    public static function empty(): MarkerList
    {
        return new self();
    }

    public static function fromArray(array $markers): MarkerList
    {
        return new self(...$markers);
    }

    public function add(Marker $marker): MarkerList
    {
        return new self($marker, ...$this->markers);
    }

    public function remove(string $markerId): MarkerList
    {
        return new self(...array_filter(
            $this->markers,
            fn (Marker $marker) => !$marker->equal($markerId),
        ));
    }

    public function update(string $markerId, callable $callback): MarkerList
    {
        return new self(...array_map(
            function (Marker $marker) use ($callback, $markerId) {
                return $marker->equal($markerId) ? $callback($marker) : $marker;
            },
            $this->markers,
        ));
    }

    public function mapTo(MapState $mapState): void
    {
        $existingMarkerIds = [];
        foreach ($this->markers as $marker) {
            $existingMarkerIds[] = $marker->id;
            $doctrineMarker = $mapState->markers->findFirst(
                fn ($key, MarkerState $doctrineMarker) => $marker->equal($doctrineMarker->markerId)
            );

            if (!$doctrineMarker) {
                $mapState->markers->add($marker->mapTo(new MarkerState(map: $mapState)));
            } else {
                $marker->mapTo($doctrineMarker);
            }
        }

        $mapState->markers = $mapState->markers->filter(
            fn (MarkerState $doctrineMarker) => in_array($doctrineMarker->markerId, $existingMarkerIds)
        );
    }
}
