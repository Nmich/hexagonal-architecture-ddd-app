<?php

use App\Domain\Map\Map;
use App\Domain\Map\MapCreated;
use Symfony\Component\Uid\Uuid;

describe('map', function () {
    it('creates a map without marker', function () {
        $id = Uuid::v4();
        $name = 'Bon plan sur Anglet';

        expect(Map::create($id, $name))->toEqual(new Map($id, $name, [new MapCreated($id, $name)]));
    });
});
