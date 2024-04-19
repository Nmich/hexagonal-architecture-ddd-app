<?php

use App\Domain\Cartographer\Username;

describe('command - username', function () {
    test('the username should contain 3 at least characters', function () {
        expect(fn() => new Username('al'))
            ->toThrow(InvalidArgumentException::class);
    });
});
