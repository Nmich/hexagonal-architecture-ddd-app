<?php

use App\Domain\Map\Marker;
use Symfony\Component\Uid\Uuid;

describe('command - marker', function () {
    it('should have the same id to equal another one', function () {
        $id = Uuid::v4();
        $map = Marker::whatever(id: $id);

        expect($map->equal($id))->toBeTrue()
            ->and($map->equal(Uuid::v4()))->toBeFalse();
    });
});
