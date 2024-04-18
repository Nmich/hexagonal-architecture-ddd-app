<?php

use App\Domain\Map\Marker;
use App\Domain\Map\MarkerList;
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
});
