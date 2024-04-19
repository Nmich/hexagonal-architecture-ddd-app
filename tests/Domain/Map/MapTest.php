<?php

use App\Domain\Map\Location;
use App\Domain\Map\Map;
use App\Domain\Map\MapCreated;
use App\Domain\Map\MapState;
use App\Domain\Map\Marker;
use App\Domain\Map\MarkerAdded;
use App\Domain\Map\MarkerDeleted;
use App\Domain\Map\MarkerMoved;
use App\Domain\Map\Name;
use App\Domain\Map\MarkerState;
use Symfony\Component\Uid\Uuid;

describe('command - map', function () {
    it('creates a map from its state', function () {
        $map = Map::fromState(new MapState(
            '5a9cc303-b286-4c15-94a1-baefe5aba425',
            'Bon plan',
            [
                new MarkerState(
                    '5a9cc303-b286-4c15-94a1-baefe5aba425',
                    'Sunset',
                    43.4833,
                    -1.5167,
                    '2021-01-01 10:20:30'
                )
            ]
        ));

        expect($map)->toEqual(
            Map::whatever(
                '5a9cc303-b286-4c15-94a1-baefe5aba425',
                'Bon plan',
                [
                    Marker::whatever(
                        '5a9cc303-b286-4c15-94a1-baefe5aba425',
                        'Sunset',
                        43.4833,
                        -1.5167,
                        '2021-01-01 10:20:30'
                    )
                ]
            )
        );
    });

    it('creates a map without marker', function () {
        $id = Uuid::v4();
        $name = 'Bon plan sur Anglet';

        expect(Map::create($id, $name))->toEqual(Map::whatever($id, $name, [], [new MapCreated($id, $name)]));
    });

    it('adds a marker to the map', function () {
        $map = Map::whatever(markers: [], events: []);

        $markerId = Uuid::v4();
        $markerName = 'Sunset';
        $latitude = 43.4833;
        $longitude = -1.5167;
        $addedAt = '2021-01-01 10:20:30';
        $map->addMarker($markerId, $markerName, $latitude, $longitude, new \DateTimeImmutable($addedAt));

        expect($map)->toEqual(
            Map::whatever(
                markers: [Marker::whatever($markerId, $markerName, $latitude, $longitude, $addedAt)],
                events: [new MarkerAdded($markerId, new Name($markerName), new Location($latitude, $longitude))],
            )
        );
    });

    it('moves a marker to a new location', function () {
        $markerId = Uuid::v4();
        $name = 'Sunset';
        $latitude = 43.4833;
        $longitude = -1.5167;
        $map = Map::whatever(markers: [
            Marker::whatever(),
            Marker::whatever($markerId, $name, $latitude, $longitude),
        ]);

        $map->moveMarker($markerId, $latitude, $longitude);

        expect($map)->toEqual(
            Map::whatever(
                markers: [
                Marker::whatever(),
                    Marker::whatever($markerId, $name, $latitude, $longitude)
                ],
                events: [
                    new MarkerMoved($markerId, new Location($latitude, $longitude))
                ]
            )
        );
    });

    it('removes a marker from the map', function () {
        $markerId = Uuid::v4();
        $map = Map::whatever(markers: [
            Marker::whatever($markerId, 'Sunset', 43.4833, -1.5167),
        ]);

        $map->removeMarker($markerId);

        expect($map)->toEqual(
            Map::whatever(markers: [], events: [
                new MarkerDeleted($markerId)
            ])
        );
    });

    it('maps a map to its state', function () {
        $markerId = Uuid::v4();
        $markerName = 'Sunset';
        $latitude = 43.4833;
        $longitude = -1.5167;
        $mapId = Uuid::v4();
        $mapName = 'Bon plan';
        $addedAt = '2021-01-01 10:20:30';
        $map = Map::whatever($mapId, $mapName, [Marker::whatever($markerId, $markerName, $latitude, $longitude, $addedAt)]);
        $doctrineMap = new MapState();

        $map->mapTo($doctrineMap);

        expect($doctrineMap)->toEqual(
            new MapState($mapId, $mapName, [
                new MarkerState($markerId, $markerName, $latitude, $longitude, $addedAt, $doctrineMap)
            ])
        );
    });

    test('a map should have the same id to equal another one', function () {
        $id = Uuid::v4();
        $map = Map::whatever($id);

        expect($map->equal($id))->toBeTrue()
            ->and($map->equal(Uuid::v4()))->toBeFalse();
    });
});
