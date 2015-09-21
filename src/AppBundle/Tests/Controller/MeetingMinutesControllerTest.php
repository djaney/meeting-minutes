<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MeetingMinutesControllerTest extends WebTestCase
{

    public function testMeetingMinutesApi(){
        $client = static::createClient();
        // create meeting
        $client->request('POST', '/api/v1/meetings',[],[],[
                'CONTENT_TYPE'=>'application/json',
            ],
            '{"name":"Fabien","description":"This is a meeting"}'
        );
        $this->assertTrue(
            $client->getResponse()->isSuccessful()
        );
        $res = json_decode($client->getResponse()->getContent());
        $id = $res->id;
        // create minutes
        $client->request('POST', '/api/v1/meetings'.$id.'/minutes',[],[],[
                'CONTENT_TYPE'=>'application/json',
            ],
            '{"name":"First"}'
        );
        $this->assertTrue(
            $client->getResponse()->isSuccessful()
        );
        $res = json_decode($client->getResponse()->getContent());
        $this->assertObjectHasAttribute('id',$res);
        $this->assertObjectHasAttribute('name',$res);
        $this->assertObjectHasAttribute('description',$res);
        $this->assertEquals('First',$res->name);
        $this->assertEquals('',$res->description);
    }

}
