<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MeetingControllerTest extends WebTestCase
{
    public function testCreate()
    {
        $client = static::createClient();

        $client->request('POST', '/m');

        $this->assertTrue(
            $client->getResponse()->isRedirect('/m/1')
        );

        $client->request('GET', '/m');
        $this->assertFalse($client->getResponse()->isSuccessful());

        $client->request('PUT', '/m');
        $this->assertFalse($client->getResponse()->isSuccessful());

        $client->request('PATCH', '/m');
        $this->assertFalse($client->getResponse()->isSuccessful());
    }
    /**
     * @depends testCreate
     */
    public function testGet()
    {
        $client = static::createClient();

        $client->request('GET', '/m/1');
        $this->assertTrue($client->getResponse()->isSuccessful());

        $client->request('GET', '/m/2');
        $this->assertFalse($client->getResponse()->isSuccessful());

        $client->request('GET', '/m/3');
        $this->assertFalse($client->getResponse()->isSuccessful());

        $client->request('GET', '/m/4');
        $this->assertFalse($client->getResponse()->isSuccessful());
    }


    /**
     * @depends testCreate
     */
    public function testChangeName()
    {
        $client = static::createClient();

        //$client->request('GET', '/api/meeting/get/1');

    }



    public function testPostApi()
    {
        $client = static::createClient();

        $client->request('POST', '/api/v1/meetings',[],[],[
                'CONTENT_TYPE'=>'application/json',
            ],
            '{"name":"Fabien","description":"This is a meeting"}'
        );

        $res = json_decode($client->getResponse()->getContent());
        $this->assertTrue(
            $client->getResponse()->isSuccessful()
        );
        $this->assertObjectHasAttribute('id',$res);
        $this->assertObjectHasAttribute('name',$res);
        $this->assertEquals('Fabien',$res->name);
        $this->assertEquals('This is a meeting',$res->description);

    }

}
