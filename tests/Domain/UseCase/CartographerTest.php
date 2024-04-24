<?php

use App\Domain\Cartographer\Cartographer;
use App\Domain\Cartographer\CartographerRegistered;
use App\Domain\Cartographer\PasswordEncryptor;
use App\Domain\Cartographer\Username;
use App\Domain\UseCase\RegisterCartographer;
use App\Domain\UseCase\RegisterCartographerHandler;
use App\Infra\Cartographer\InMemoryCartographers;
use App\Infra\Cartographer\InMemoryPasswordEncryptor;
use Symfony\Component\Uid\Uuid;

describe('cartographer use cases', function () {
    test('a cartographer registers on the application [fake]', function () {
        $inMemoryCartographer = new InMemoryCartographers();

        $id = Uuid::v4();
        $username = 'arn0';
        $password = '$2a$12$pTBZuTRRWbdtQ8VPaZSzOe.PNebOr/yDNZvU6tq0R/XzX9l5fWDlS';
        (new RegisterCartographerHandler(
            $inMemoryCartographer,
            new InMemoryPasswordEncryptor()
        ))(new RegisterCartographer($id, $username, $password));

        expect($inMemoryCartographer->get($id))->toEqual(Cartographer::whatever($id, $username, $password, [
            new CartographerRegistered($id, new Username($username))
        ]));
    });

    test('a cartographer registers on the application [stub]', function () {
        $inMemoryCartographer = new InMemoryCartographers();
        $passwordEncryptor = Mockery::mock(PasswordEncryptor::class);

        $id = Uuid::v4();
        $username = 'arn0';
        $password = '$2a$12$pTBZuTRRWbdtQ8VPaZSzOe.PNebOr/yDNZvU6tq0R/XzX9l5fWDlS';

        $passwordEncryptor->shouldReceive('encrypt')->andReturn('$2a$12$pTBZuTRRWbdtQ8VPaZSzOe.PNebOr/yDNZvU6tq0R/XzX9l5fWDlS');

        (new RegisterCartographerHandler(
            $inMemoryCartographer,
            $passwordEncryptor
        ))(new RegisterCartographer($id, $username, $password));

        expect($inMemoryCartographer->get($id))->toEqual(Cartographer::whatever($id, $username, $password, [
            new CartographerRegistered($id, new Username($username))
        ]));
    });
});
