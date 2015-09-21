<?php

namespace AppBundle\ApiController;

use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
class MeetingController extends FOSRestController implements ClassResourceInterface
{
    public function getAction($id){
        $meeting = $this->get('facade.meeting')->getById($id);
        return $meeting;
    }

    public function postAction(Request $req){
        $name = $req->request->get('name','');
        $description = $req->request->get('description','');
        $meeting = $this->get('facade.meeting')->create()->getSubject();
        $meeting->setName($name);
        $meeting->setDescription($description);
        $this->get('facade.meeting')->flush();
        return $meeting;
    }
}
