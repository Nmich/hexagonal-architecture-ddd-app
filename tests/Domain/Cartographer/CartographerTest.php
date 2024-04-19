<?php


use App\Domain\Cartographer\Cartographer;
use Symfony\Component\Uid\Uuid;

describe('cartographer', function () {
    it('should have the same id to equal another one', function () {
        $id = Uuid::v4();
        $cartographer = Cartographer::whatever(id: $id);

        expect($cartographer->equal($id))->toBeTrue()
            ->and($cartographer->equal(Uuid::v4()))->toBeFalse();
    });
});
