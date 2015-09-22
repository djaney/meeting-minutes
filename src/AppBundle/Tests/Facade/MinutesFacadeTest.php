<?php

namespace AppBundle\Tests\Facade;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MinutesFacadeTest extends WebTestCase
{
    public function testMinutes(){
        $client = static::createClient();
        $svc = $client->getContainer()->get('facade.meeting');
        $minSvc = $client->getContainer()->get('facade.minutes');
        $crazyString = ' !"#$%&\'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^_`abcdefghijklmnopqrstuvwxyz{|}~';

        $m = $svc->create()
            ->mutate(function($subject) use ($crazyString){
                $subject->setName('Test Meeting')->setDescription($crazyString);
            })
            ->addMinute($minSvc->create()->patch(['name'=>'0','description'=>'0d'])->getSubject())
            ->addMinute($minSvc->create()->patch(['name'=>'1','description'=>'1d'])->getSubject())
            ->addMinute($minSvc->create()->patch(['name'=>'2','description'=>'2d'])->getSubject())
        ;
        $id = $m->getSubject()->getId();
        $m->flush();
        $this->assertCount(3,$m->getById($id)->getMinutes());

        $minutes = $m->getById($id)->getMinutes();
        $this->assertEquals('0',$minutes[0]->getName());
        $this->assertEquals('0d',$minutes[0]->getDescription());


    }

}
