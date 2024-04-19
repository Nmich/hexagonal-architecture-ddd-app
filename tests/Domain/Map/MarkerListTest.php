<?php

use App\Domain\Map\MapState;
use App\Domain\Map\Marker;
use App\Domain\Map\MarkerList;
use App\Domain\Map\MarkerState;
use Symfony\Component\Uid\Uuid;

describe('command - marker list', function () {
    it('adds a marker to the list', function () {
        $markers = MarkerList::empty();

        $marker = Marker::whatever();
        $newMarkers = $markers->add($marker);

        expect($newMarkers)->toEqual(new MarkerList($marker));
    });

    it('removes a marker from the list', function () {
        $markerId = Uuid::v4();
        $marker = Marker::whatever(id: $markerId);
        $markers = new MarkerList($marker);

        $newMarkers = $markers->remove($markerId);

        expect($newMarkers)->toEqual(new MarkerList());
    });

    it('updates a marker from the list', function () {
        $markerId = Uuid::v4();
        $marker = Marker::whatever(id: $markerId);
        $markers = new MarkerList($marker);

        $newMarkers = $markers->update(
            $markerId,
            function (Marker $marker) {
                $marker->move(55.4833, -15.5167);
                return $marker;
            }
        );

        expect($newMarkers)->toEqual(new MarkerList(
            Marker::whatever(id: $markerId, latitude: 55.4833, longitude: -15.5167)
        ));
    });

    it('adds markers to the state when they do not exist', function () {
        $markerId = Uuid::v4();
        $markerName = 'Sunset';
        $latitude = 43.4833;
        $longitude = -1.5167;
        $addedAt = '2021-01-01 10:20:30';
        $markers = new MarkerList(Marker::whatever($markerId, $markerName, $latitude, $longitude, $addedAt));
        $MapState = new MapState();

        $markers->mapTo($MapState);

        expect($MapState)->toEqual(new MapState(
            markers: [new MarkerState($markerId, $markerName, $latitude, $longitude, $addedAt, $MapState)]
        ));
    });

    it('updates markers from the state when they exist', function () {
        $markerId = Uuid::v4();
        $markerName = 'Sunset';
        $latitude = 43.4833;
        $longitude = -1.5167;
        $addedAt = '2021-01-01 10:20:30';
        $markers = new MarkerList(Marker::whatever($markerId, $markerName, $latitude, $longitude, $addedAt));
        $MapState = new MapState();
        $MarkerState = new MarkerState($markerId, 'name', 12, 13, $addedAt, $MapState);
        $MapState->markers->add($MarkerState);

        $markers->mapTo($MapState);

        expect($MapState)->toEqual(new MapState(
            markers: [new MarkerState($markerId, $markerName, $latitude, $longitude, $addedAt, $MapState)]
        ));
    });

    it('removes markers from the state when they have been removed', function () {
        $markerId = Uuid::v4();
        $markers = new MarkerList(Marker::whatever($markerId));
        $MapState = new MapState();
        $MarkerState = new MarkerState(Uuid::v4());
        $MapState->markers->add($MarkerState);

        $markers->mapTo($MapState);

        expect($MapState)->toEqual(new MapState(
            markers: [1 => new MarkerState($markerId, 'Sunset', 48.8534, 2.3488, '2021-01-01 00:00:00', $MapState)]
        ));
    });
});
