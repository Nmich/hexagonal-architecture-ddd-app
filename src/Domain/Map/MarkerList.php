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
}
