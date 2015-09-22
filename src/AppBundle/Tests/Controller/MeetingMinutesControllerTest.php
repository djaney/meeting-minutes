<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MeetingMinutesControllerTest extends WebTestCase
{
    private $client;
    public function setUp(){
        $this->client = static::createClient();
    }
    public function testCreateMeeting(){

        $this->client->request('POST', '/api/v1/meetings',[],[],[
                'CONTENT_TYPE'=>'application/json',
            ],
            '{"name":"Fabien","description":"This is a meeting"}'
        );
        $this->assertTrue(
            $this->client->getResponse()->isSuccessful()
        );
        $res = json_decode($this->client->getResponse()->getContent());
        return $res->id;
    }
    /**
     * @depends testCreateMeeting
     */
    public function testCreateMinute($id){

        // create minutes
        $this->client->request('POST', '/api/v1/meetings/'.$id.'/minutes',[],[],[
                'CONTENT_TYPE'=>'application/json',
            ],
            '{"name":"First"}'
        );
        $res = json_decode($this->client->getResponse()->getContent());
        $this->assertTrue(
            $this->client->getResponse()->isSuccessful()
        );
        $this->assertObjectHasAttribute('id',$res);
        $this->assertObjectHasAttribute('name',$res);
        $this->assertObjectHasAttribute('description',$res);
        $this->assertEquals('First',$res->name);
        $this->assertEquals('',$res->description);
        return [$id,$res->id];

    }
    /**
     * @depends testCreateMinute
     */
    public function testPatchMinute($arr){
        // create minutes
        $this->client->request('PATCH', '/api/v1/meetings/'.$arr[0].'/minutes/'.$arr[1],[],[],[
                'CONTENT_TYPE'=>'application/json',
            ],
            '{"name":"Second","description":"Second"}'
        );
        $res = json_decode($this->client->getResponse()->getContent());
        $this->assertTrue(
            $this->client->getResponse()->isSuccessful()
        );
        $this->assertObjectHasAttribute('id',$res);
        $this->assertObjectHasAttribute('name',$res);
        $this->assertObjectHasAttribute('description',$res);
        $this->assertEquals('Second',$res->name);
        $this->assertEquals('Second',$res->description);
    }

}
