<?php

namespace App\Infra\Map;


use App\Domain\Map\Map;
use App\Domain\Map\Maps;
use App\Domain\Map\MapState;
use App\Domain\Map\UnknownMap;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\ORMInvalidArgumentException;

final class DoctrineMaps implements Maps
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function add(Map $map): void
    {
        try {
            /** @var MapState $mapState */
            if (!$mapState = $this->entityManager->find(MapState::class, $map->id)) {
                $mapState = new MapState();
            }
            $map->mapTo($mapState);
            $this->entityManager->persist($mapState);
            $this->entityManager->flush();
        } catch (ORMInvalidArgumentException|ORMException $e) {
            throw new \LogicException('Cannot persist a map', 0, $e);
        }
    }

    public function get(string $id): Map
    {
        try {
            /** @var MapState $doctrineMap */
            if (!$doctrineMap = $this->entityManager->find(MapState::class, $id)) {
                throw UnknownMap::fromId($id);
            }

            return Map::fromState($doctrineMap);
        } catch (ORMInvalidArgumentException|ORMException $e) {
            throw new \LogicException('Cannot retrieve a map', 0, $e);
        }
    }
}
