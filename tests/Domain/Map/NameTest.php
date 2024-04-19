<?php

use App\Domain\Map\Name;

describe('command - name', function () {
    test('the name of the map cannot be empty', function () {
        expect(fn() => new Name(''))
            ->toThrow(\InvalidArgumentException::class);
    });
});
