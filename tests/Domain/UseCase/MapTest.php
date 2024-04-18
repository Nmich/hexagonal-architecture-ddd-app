<?php

use App\Domain\Map\InMemoryMaps;
use App\Domain\Map\Location;
use App\Domain\Map\Map;
use App\Domain\Map\Marker;
use App\Domain\Map\Name;
use App\Domain\UseCase\AddMarkerToMap;
use App\Domain\UseCase\AddMarkerToMapHandler;
use App\Domain\Map\MapCreated;
use App\Domain\UseCase\CreateMap;
use App\Domain\UseCase\CreateMapHandler;
use Symfony\Component\Uid\Uuid;

describe('map use cases', function () {
    test('a cartographer creates a map', function () {
        $maps = new InMemoryMaps();

        $id = Uuid::v4();
        $name = 'Bon plan sur Anglet';
        (new CreateMapHandler($maps))(new CreateMap($id, $name));

        expect($maps->get($id))->toEqual(new Map($id, $name, [], [new MapCreated($id, $name)]));
    });

    test('a cartographer adds marker to a map', function () {
        $mapId = Uuid::v4();
        $mapName = 'Bon plan sur Anglet';
        $maps = new InMemoryMaps([new Map($mapId, $mapName, [])]);

        $markerId = Uuid::v4();
        $name = 'Sunset';
        $latitude = 43.4833;
        $longitude = -1.5167;
        (new AddMarkerToMapHandler($maps))(new AddMarkerToMap($mapId, $markerId, $name, $latitude, $longitude));

        expect($maps->get($mapId))->toEqual(new Map($mapId, $mapName, [
            new Marker($markerId, new Name($name), new Location($latitude, $longitude))
        ]));
    });
});
