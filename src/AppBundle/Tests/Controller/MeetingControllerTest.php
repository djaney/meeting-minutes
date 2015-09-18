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

        $client->request('POST', '/meeting/create');
        $this->assertFalse($client->getResponse()->isSuccessful());

        $client->request('PUT', '/meeting/create');
        $this->assertFalse($client->getResponse()->isSuccessful());

        $client->request('PATCH', '/meeting/create');
        $this->assertFalse($client->getResponse()->isSuccessful());
    }
    /**
     * @depends testCreate
     */
    public function testGet()
    {
        $client = static::createClient();

        $client->request('GET', '/meeting/get/1 ');
        $this->assertTrue($client->getResponse()->isSuccessful());

        $client->request('GET', '/meeting/get/2 ');
        $this->assertFalse($client->getResponse()->isSuccessful());
        
        $client->request('GET', '/meeting/get/3 ');
        $this->assertFalse($client->getResponse()->isSuccessful());

        $client->request('GET', '/meeting/get/4 ');
        $this->assertFalse($client->getResponse()->isSuccessful());
    }

}
