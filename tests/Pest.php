<?php

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Form\Test\TypeTestCase;

(new Dotenv())->bootEnv(dirname(__DIR__).'/.env.test');

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(KernelTestCase::class)->in('Infra');
uses()->beforeEach(fn () => $this->container = $this->getContainer())->in('Infra');

uses(TypeTestCase::class)->in('UserInterface/*/*Type*.php');
uses(WebTestCase::class)->in('UserInterface/*/Web*.php');
uses(WebTestCase::class)->in('UserInterface/*/Api*.php');
uses(KernelTestCase::class)->in('UserInterface/*/Cli*.php');
