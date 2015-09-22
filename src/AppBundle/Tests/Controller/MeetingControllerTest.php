<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MeetingControllerTest extends WebTestCase
{
    public function testCreate()
    {
        $client = static::createClient();

        $client->request('GET', '/m/new');

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


        $client->request('POST', '/api/v1/meetings',[],[],[
                'CONTENT_TYPE'=>'application/json',
            ]
        );

        $this->assertFalse(
            $client->getResponse()->isSuccessful()
        );
        $res = json_decode($client->getResponse()->getContent());
        $this->assertObjectHasAttribute('errors',$res);
        $this->assertObjectHasAttribute('field',$res->errors[0]);
        $this->assertObjectHasAttribute('message',$res->errors[0]);
        $this->assertEquals('name',$res->errors[0]->field);
        $this->assertEquals('This value should not be blank.',$res->errors[0]->message);
    }


    public function testPatchApi()
    {
        $client = static::createClient();
        // test post
        $client->request('POST', '/api/v1/meetings',[],[],[
                'CONTENT_TYPE'=>'application/json',
            ],
            '{"name":"Fabien","description":"This is a meeting"}'
        );
        $res = json_decode($client->getResponse()->getContent());
        $id = $res->id;
        // patch after post
        $client->request('PATCH', '/api/v1/meetings/'.$id,[],[],[
                'CONTENT_TYPE'=>'application/json',
            ],
            '{"name":"Patched","description":"Shinku Hadokkenn!!!"}'
        );
        $res = json_decode($client->getResponse()->getContent());
        $this->assertObjectHasAttribute('id',$res);
        $this->assertObjectHasAttribute('name',$res);
        $this->assertObjectHasAttribute('description',$res);
        $this->assertEquals('Patched',$res->name);
        $this->assertEquals('Shinku Hadokkenn!!!',$res->description);

        // patch with validation error
        $client->request('PATCH', '/api/v1/meetings/'.$id,[],[],[
                'CONTENT_TYPE'=>'application/json',
            ],
            '{"name":"","description":""}'
        );

        $this->assertFalse(
            $client->getResponse()->isSuccessful()
        );
        $res = json_decode($client->getResponse()->getContent());
        $this->assertObjectHasAttribute('errors',$res);
        $this->assertObjectHasAttribute('field',$res->errors[0]);
        $this->assertObjectHasAttribute('message',$res->errors[0]);
        $this->assertEquals('name',$res->errors[0]->field);
        $this->assertEquals('This value should not be blank.',$res->errors[0]->message);

        // check if value is commited even with error
        $client->request('GET', '/api/v1/meetings/'.$id);

        $this->assertTrue(
            $client->getResponse()->isSuccessful()
        );
        $res = json_decode($client->getResponse()->getContent());
        $this->assertObjectHasAttribute('id',$res);
        $this->assertObjectHasAttribute('name',$res);
        $this->assertObjectHasAttribute('description',$res);
        $this->assertEquals('Patched',$res->name);
        $this->assertEquals('Shinku Hadokkenn!!!',$res->description);
    }

    public function testDelete(){
        $client = static::createClient();
        // test post
        $client->request('POST', '/api/v1/meetings',[],[],[
                'CONTENT_TYPE'=>'application/json',
            ],
            '{"name":"This is to be deleted","description":"sad news"}'
        );

        $res = json_decode($client->getResponse()->getContent());
        $id = $res->id;


        $client->request('GET', '/api/v1/meetings/'.$id);
        $this->assertTrue(
            $client->getResponse()->isSuccessful()
        );

        $client->request('DELETE', '/api/v1/meetings/'.$id);
        $this->assertTrue(
            $client->getResponse()->isSuccessful()
        );

        $client->request('GET', '/api/v1/meetings/'.$id);
        $this->assertFalse(
            $client->getResponse()->isSuccessful()
        );


    }





}
