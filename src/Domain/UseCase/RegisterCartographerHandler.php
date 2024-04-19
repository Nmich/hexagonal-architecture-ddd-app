<?php

namespace App\Domain\UseCase;

use App\Domain\Cartographer\Cartographer;
use App\Domain\Cartographer\Cartographers;
use App\Domain\Cartographer\PasswordEncryptor;

final class RegisterCartographerHandler
{
    public function __construct(
        private readonly Cartographers $cartographers,
        private readonly PasswordEncryptor $passwordEncryptor,
    ) {
    }

    public function __invoke(RegisterCartographer $registerCartographer): void
    {
        $this->cartographers->add(
            Cartographer::register(
                $registerCartographer->id,
                $registerCartographer->username,
                $registerCartographer->password,
                $this->passwordEncryptor
            )
        );
    }
}
