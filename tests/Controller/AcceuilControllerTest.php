<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AccueilControllerTest extends WebTestCase
{
    public function testAccueilIsUp(): void
    {
        $client = static::createClient();
        $client->catchExceptions(false);
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
    }
}