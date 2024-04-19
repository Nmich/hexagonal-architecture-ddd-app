<?php

use App\Domain\Cartographer\Password;
use App\Infra\Cartographer\InMemoryPasswordEncryptor;

describe('command - password', function () {
    it('creates a password from the valid string', function () {
        expect(Password::fromString('Arn0arn0', new InMemoryPasswordEncryptor()))
            ->toEqual(Password::fromHash('$2a$12$pTBZuTRRWbdtQ8VPaZSzOe.PNebOr/yDNZvU6tq0R/XzX9l5fWDlS'));
    });

    test('the password should contain at least a number, an uppercase letter and an lowercase letter', function ($password) {
        expect(fn() => Password::fromString($password, new InMemoryPasswordEncryptor()))
            ->toThrow(InvalidArgumentException::class);
    })->with([
        'arn0arn0',
        'ARN0ARN0',
        'ArnoArno',
    ]);

    test('the password length is 8 characters', function ($password) {
        expect(fn() => Password::fromString($password, new InMemoryPasswordEncryptor()))
            ->toThrow(InvalidArgumentException::class);
    })->with([
        'Arn0an0',
    ]);
});
