<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/m")
 * @Template()
 */
class MeetingController extends Controller
{
    /**
     * @Route("/new")
     * @Method("GET")
     */
    public function newAction()
    {
        $meeting = $this->get('facade.meeting')->create()->getSubject();
        return $this->redirectToRoute('app_meeting_get',['id'=>$meeting->getId()]);
    }

    /**
     * @Route("/{id}")
     * @Method("GET")
     */
    public function getAction($id)
    {
        $meeting = $this->get('facade.meeting')->getById($id);
        if($meeting===null){
            throw $this->createNotFoundException('Meeting does not exist');
        }
        return array(
                // ...
            );
    }

}
