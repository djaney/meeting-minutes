<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MeetingServiceTest extends WebTestCase
{
    public function testCreate()
    {
        $client = static::createClient();
        $svc = $client->getContainer()->get('app.meeting');

        $m = $svc->create();
        $this->assertNotNull($svc->getById($m->getId()));

        $m = $svc->create('');
        $this->assertNotNull($svc->getById($m->getId()));
        $crazyString = ' !"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^_`abcdefghijklmnopqrstuvwxyz{|}~';
        $m = $svc->create($crazyString);
        $this->assertEquals($crazyString,$svc->getById($m->getId())->getName());
    }


}
