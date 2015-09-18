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
        $this->assertNotNull($m);
    }


}
