<?php

use App\Domain\Map\Location;
use App\Domain\Map\Map;
use App\Domain\Map\MapCreated;
use App\Domain\Map\Marker;
use App\Domain\Map\MarkerAdded;
use App\Domain\Map\Name;
use Symfony\Component\Uid\Uuid;

describe('command - map', function () {
    it('creates a map without marker', function () {
        $id = Uuid::v4();
        $name = 'Bon plan sur Anglet';

        expect(Map::create($id, $name))->toEqual(new Map($id, $name, [], [new MapCreated($id, $name)]));
    });

    it('adds a marker to the map', function () {
        $markerId = Uuid::v4();
        $map = Map::whatever(markers: [], events: []);

        $markerId = Uuid::v4();
        $markerName = 'Sunset';
        $latitude = 43.4833;
        $longitude = -1.5167;
        $map->addMarker($markerId, $markerName, $latitude, $longitude);

        expect($map)->toEqual(
            Map::whatever(
                markers: [Marker::whatever($markerId, 'Sunset', 43.4833, -1.5167)],
                events: [new MarkerAdded($markerId, new Name($markerName), new Location($latitude, $longitude))],
            )
        );
    });

    it('moves a marker to a new location', function () {
        $markerId = Uuid::v4();
        $map = Map::whatever(markers: [
            Marker::whatever(),
            Marker::whatever($markerId, 'Sunset', 43.4833, -1.5167),
        ]);

        $map->moveMarker($markerId, 43.4833, -1.5167);

        expect($map)->toEqual(
            Map::whatever(markers: [
                Marker::whatever(),
                Marker::whatever($markerId, 'Sunset', 43.4833, -1.5167)
            ])
        );
    });

    it('removes a marker from the map', function () {
        $markerId = Uuid::v4();
        $map = Map::whatever(markers: [
            Marker::whatever($markerId, 'Sunset', 43.4833, -1.5167),
        ]);

        $map->removeMarker($markerId);

        expect($map)->toEqual(
            Map::whatever(markers: [])
        );
    });

    test('a map should have the same id to equal another one', function () {
        $id = Uuid::v4();
        $map = Map::whatever($id);

        expect($map->equal($id))->toBeTrue()
            ->and($map->equal(Uuid::v4()))->toBeFalse();
    });
});
