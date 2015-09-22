<?php

namespace AppBundle\Tests\Facade;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MeetingFacadeTest extends WebTestCase
{
    public function testCreate()
    {
        $client = static::createClient();
        $svc = $client->getContainer()->get('facade.meeting');

        $m = $svc->create()->getSubject();
        $this->assertNotNull($svc->getById($m->getId()));

        $m = $svc->create('')->getSubject();
        $this->assertNotNull($svc->getById($m->getId()));
        $crazyString = ' !"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^_`abcdefghijklmnopqrstuvwxyz{|}~';
        $m = $svc->create()->getSubject()->setName($crazyString);
        $this->assertEquals($crazyString,$svc->getById($m->getId())->getName());
    }


}
