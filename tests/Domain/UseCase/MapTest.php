<?php

use App\Domain\Clock;
use App\Domain\Map\Location;
use App\Domain\Map\Map;
use App\Domain\Map\MapCreated;
use App\Domain\Map\Marker;
use App\Domain\Map\MarkerAdded;
use App\Domain\Map\MarkerDeleted;
use App\Domain\Map\MarkerMoved;
use App\Domain\Map\Name;
use App\Domain\UseCase\AddMarkerToMap;
use App\Domain\UseCase\AddMarkerToMapHandler;
use App\Domain\UseCase\CreateMap;
use App\Domain\UseCase\CreateMapHandler;
use App\Domain\UseCase\MoveMarker;
use App\Domain\UseCase\MoveMarkerHandler;
use App\Domain\UseCase\RemoveMarker;
use App\Domain\UseCase\RemoveMarkerHandler;
use App\Infra\Clock\InMemoryClock;
use App\Infra\Map\DummyMarkerLocationDatabaseClient;
use App\Infra\Map\InMemoryMaps;
use Symfony\Component\Uid\Uuid;

describe('map use cases', function () {
    test('a cartographer creates a map', function () {
        $maps = new InMemoryMaps();

        $id = Uuid::v4();
        $name = 'Bon plan sur Anglet';
        (new CreateMapHandler($maps))(new CreateMap($id, $name));

        expect($maps->get($id))->toEqual(Map::whatever($id, $name, [], [new MapCreated($id, $name)]));
    });

    test('a cartographer adds marker to a map [fake]', function () {
        $mapId = Uuid::v4();
        $maps = new InMemoryMaps([Map::whatever(id: $mapId, markers: [])]);

        $markerId = Uuid::v4();
        $name = 'Sunset';
        $latitude = 43.4833;
        $longitude = -1.5167;
        $addedAt = '2021-01-01 10:20:30';
        $clock = new InMemoryClock($addedAt);

        (new AddMarkerToMapHandler(
            $maps,
            new DummyMarkerLocationDatabaseClient(),
            $clock
        ))(new AddMarkerToMap($mapId, $markerId, $name, $latitude, $longitude));

        expect($maps->get($mapId))->toEqual(Map::whatever(id: $mapId,
            markers: [Marker::whatever($markerId, $name, $latitude, $longitude, $addedAt)],
            events: [new MarkerAdded($markerId, new Name($name), new Location($latitude, $longitude))]
        ));
    });

    test('a cartographer adds marker to a map [stub]', function () {
        $mapId = Uuid::v4();
        $maps = new InMemoryMaps([Map::whatever(id: $mapId, markers: [])]);
        $clock = Mockery::mock(Clock::class);

        $markerId = Uuid::v4();
        $name = 'Sunset';
        $latitude = 43.4833;
        $longitude = -1.5167;
        $addedAt = '2021-01-01 10:20:30';
        $clock->shouldReceive('now')->andReturn(new \DateTimeImmutable($addedAt));

        (new AddMarkerToMapHandler(
            $maps,
            new DummyMarkerLocationDatabaseClient(),
            $clock
        ))(new AddMarkerToMap($mapId, $markerId, $name, $latitude, $longitude));

        expect($maps->get($mapId))->toEqual(Map::whatever(id: $mapId,
            markers: [Marker::whatever($markerId, $name, $latitude, $longitude, $addedAt)],
            events: [new MarkerAdded($markerId, new Name($name), new Location($latitude, $longitude))]
        ));
    });

    test('a cartographer moves marker to a new location', function () {
        $mapId = Uuid::v4();
        $markerId = Uuid::v4();
        $maps = new InMemoryMaps([Map::whatever(id: $mapId, markers: [
            Marker::whatever(id: $markerId)
        ])]);

        $newLatitude = 43.4833;
        $newLongitude = -1.5167;
        (new MoveMarkerHandler($maps))(new MoveMarker($mapId, $markerId, $newLatitude, $newLongitude));

        expect($maps->get($mapId))->toEqual(Map::whatever(id: $mapId,
            markers: [Marker::whatever(id: $markerId, latitude: $newLatitude, longitude: $newLongitude)],
            events: [new MarkerMoved($markerId, new Location($newLatitude, $newLongitude))]
        ));
    });

    test('a cartographer removes marker from the map', function () {
        $mapId = Uuid::v4();
        $markerId = Uuid::v4();
        $maps = new InMemoryMaps([Map::whatever(id: $mapId, markers: [
            Marker::whatever(id: $markerId)
        ])]);

        (new RemoveMarkerHandler($maps))(new RemoveMarker($mapId, $markerId));

        expect($maps->get($mapId))->toEqual(Map::whatever(id: $mapId, markers: [], events: [
            new MarkerDeleted($markerId)
        ]));
    });
});
