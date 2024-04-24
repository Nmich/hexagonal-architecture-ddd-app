<?php


use App\Domain\Cartographer\Cartographer;
use App\Domain\Cartographer\CartographerRegistered;
use App\Domain\Cartographer\Username;
use App\Infra\Cartographer\InMemoryPasswordEncryptor;
use Symfony\Component\Uid\Uuid;

describe('cartographer', function () {
    it('register a new cartographer', function () {
        $id = Uuid::v4();
        $username = 'arn0';
        $password = '$2a$12$pTBZuTRRWbdtQ8VPaZSzOe.PNebOr/yDNZvU6tq0R/XzX9l5fWDlS';

        expect(Cartographer::register($id, $username, $password, new InMemoryPasswordEncryptor()))
            ->toEqual(Cartographer::whatever($id, $username, $password, [new CartographerRegistered($id, new Username($username))]));
    });

    it('should have the same id to equal another one', function () {
        $id = Uuid::v4();
        $cartographer = Cartographer::whatever(id: $id);

        expect($cartographer->equal($id))->toBeTrue()
            ->and($cartographer->equal(Uuid::v4()))->toBeFalse();
    });
});
