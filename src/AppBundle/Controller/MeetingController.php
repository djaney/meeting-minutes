<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/meeting")
 * @Template()
 */
class MeetingController extends Controller
{
    /**
     * @Route("/create")
     */
    public function createAction()
    {
        $meeting = $this->get('factory.meeting')->create();
        return $this->redirectToRoute('app_meeting_get',['id'=>$meeting->getId()]);
    }

    /**
     * @Route("/get/{id}")
     */
    public function getAction($id)
    {
        return array(
                // ...
            );    }

}
