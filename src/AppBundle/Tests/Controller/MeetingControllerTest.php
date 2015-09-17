<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MeetingControllerTest extends WebTestCase
{
    public function testCreate()
    {
        $client = static::createClient();

        $client->request('GET', '/meeting/create');

        $this->assertTrue(
            $client->getResponse()->isRedirect('/meeting/get/1')
        );
    }

    public function testGet()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/meeting/get/1 ');
    }

}
