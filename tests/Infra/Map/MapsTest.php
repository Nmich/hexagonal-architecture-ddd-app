<?php

use App\Domain\Map\Map;
use App\Domain\Map\Maps;
use App\Domain\Map\Marker;
use App\Domain\Map\UnknownMap;
use App\Infra\Database;
use App\Infra\Map\DoctrineMaps;
use App\Infra\Map\InMemoryMaps;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

describe('infra - maps', function () {
    it('persists and retrieves a map with marker', function ($serviceName) {
        $this->container->get(Database::class)->truncateAllTables();
        $maps = $this->container->get($serviceName);

        $id = Uuid::v4();
        $map = Map::whatever(id: $id, markers: [
            Marker::whatever(Uuid::v4()),
            Marker::whatever(Uuid::v4()),
        ]);

        $maps->add($map);

        // On est sûr que le map n'est plus gardé en mémoire (Identity Map Pattern)
        if ($maps instanceof Maps) {
            $this->container->get(EntityManagerInterface::class)->detach($map);
        }

        expect($maps->get($id))->toEqual($map);
    })->with([
        InMemoryMaps::class,
        DoctrineMaps::class,
    ]);

    it('raises an error when I try to retrieve an unknown map', function ($serviceName) {
        $maps = $this->container->get($serviceName);

        expect(fn() => $maps->get(Uuid::v4()))
            ->toThrow(UnknownMap::class);
    })->with([
        InMemoryMaps::class,
        DoctrineMaps::class,
    ]);
});
