<?php

namespace App\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FormationRepositoryTest extends KernelTestCase
{
    public function testFindAll(): void
    {
        self::bootKernel();

        $container = static::getContainer();
        $repo = $container->get(\App\Repository\FormationRepository::class);

        $formations = $repo->findAll();

        $this->assertIsArray($formations);
    }
}