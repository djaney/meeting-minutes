<?php

namespace AppBundle\ApiController;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Routing\ClassResourceInterface;

class MeetingController extends FOSRestController implements ClassResourceInterface
{
    public function getAction($id){
        $meeting = $this->get('facade.meeting')->getById($id);
        return $meeting;
    }
}
