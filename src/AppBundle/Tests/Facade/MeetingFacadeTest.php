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

    public function testMinutes(){
        $client = static::createClient();
        $svc = $client->getContainer()->get('facade.meeting');
        $crazyString = ' !"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^_`abcdefghijklmnopqrstuvwxyz{|}~';

        $m = $svc->create()
            ->mutate(function($subject) use ($crazyString){
                $subject->setName('Test Meeting')->setDescription($crazyString);
            })
            ->addMinute('0','0d')
            ->addMinute('1','1d')
            ->addMinute('2','2d')
        ;
        $id = $m->getSubject()->getId();
        $m->flush();
        $this->assertCount(3,$m->getById($id)->getMinutes());

        $minutes = $m->getById($id)->getMinutes();
        $this->assertEquals('0',$minutes[0]->getName());
        $this->assertEquals('0d',$minutes[0]->getDescription());


    }


}
