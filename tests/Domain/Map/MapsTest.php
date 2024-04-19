<?php

use App\Domain\Map\Map;
use App\Domain\Map\Marker;
use App\Domain\Map\UnknownMap;
use App\Infra\Map\InMemoryMaps;
use Symfony\Component\Uid\Uuid;

describe('infra - maps', function () {
    it('persists and retrieves a map with marker', function () {
        $maps = new InMemoryMaps();

        $id = Uuid::v4();
        $map = Map::whatever(id: $id, markers: [
            Marker::whatever(Uuid::v4()),
            Marker::whatever(Uuid::v4()),
        ]);


        $maps->add($map);

        expect($maps->get($id))->toEqual($map);
    });

    it('raises an error when I try to retrieve an unknown map', function () {
        $maps = new InMemoryMaps();

        expect(fn() => $maps->get(Uuid::v4()))
            ->toThrow(UnknownMap::class);
    });
});
