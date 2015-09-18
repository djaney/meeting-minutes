<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/meeting")
 * @Template()
 */
class MeetingController extends Controller
{
    /**
     * @Route("/create")
     * @Method("GET")
     */
    public function createAction()
    {
        $meeting = $this->get('app.meeting')->create();
        return $this->redirectToRoute('app_meeting_get',['id'=>$meeting->getId()]);
    }

    /**
     * @Route("/get/{id}")
     * @Method("GET")
     */
    public function getAction($id)
    {
        $meeting = $this->get('app.meeting')->getById($id);
        if($meeting===null){
            throw $this->createNotFoundException('Meeting does not exist');
        }
        return array(
                // ...
            );
        }

}