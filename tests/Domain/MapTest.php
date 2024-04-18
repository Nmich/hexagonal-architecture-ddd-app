<?php

use App\Domain\Map\Location;
use App\Domain\Map\Map;
use App\Domain\Map\Marker;
use App\Domain\Map\Name;
use App\Domain\Map\MapCreated;
use Symfony\Component\Uid\Uuid;

describe('command - map', function () {
    it('creates a map without marker', function () {
        $id = Uuid::v4();
        $name = 'Bon plan sur Anglet';

        expect(Map::create($id, $name))->toEqual(new Map($id, $name, [], [new MapCreated($id, $name)]));
    });

    it('adds a marker to the map', function () {
        $mapId = Uuid::v4();
        $mapName = 'Bon plan sur Anglet';
        $map = new Map($mapId, $mapName, []);

        $markerId = Uuid::v4();
        $markerName = 'Sunset';
        $latitude = 43.4833;
        $longitude = -1.5167;
        $map->addMarker($markerId, $markerName, $latitude, $longitude);

        expect($map)->toEqual(
            new Map(
                $mapId, $mapName,
                [new Marker($markerId, new Name($markerName), new Location($latitude, $longitude))]
            )
        );
    });

    test('a map should have the same id to equal another one', function () {
        $id = Uuid::v4();
        $map = new Map($id, 'map name');

        expect($map->equal($id))->toBeTrue()
            ->and($map->equal(Uuid::v4()))->toBeFalse();
    });
});
