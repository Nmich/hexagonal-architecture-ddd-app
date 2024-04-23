<?php

use App\Domain\Map\InMemoryMaps;
use App\Domain\Map\Map;
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

        expect($maps->get($id))->toEqual(new Map($id, $name, [new MapCreated($id, $name)]));
    });
});
