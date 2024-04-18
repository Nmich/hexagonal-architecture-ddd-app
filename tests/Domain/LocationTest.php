<?php

use App\Domain\Map\Location;

describe('command - location', function () {
    test('the latitude should be between -90 and 90', function ($latitude) {
        expect(fn() => new Location($latitude, 110))
            ->toThrow(\OutOfRangeException::class);
    })->with([
        -90.1,
        90.1,
    ]);

    test('the longitude should be between -180 and 180', function ($longitude) {
        expect(fn() => new Location(30, $longitude))
            ->toThrow(\OutOfRangeException::class);
    })->with([
        -180.1,
        180.1,
    ]);
});
