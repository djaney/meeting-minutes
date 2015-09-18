<?php
namespace AppBundle\Service;
use AppBundle\Entity\Meeting;
class MeetingService {
    private $doctrine;

    public function __construct($doctrine){
        $this->doctrine = $doctrine;
    }

    public function create(){
        $meeting = new Meeting();
        $this->doctrine->getManager()->persist($meeting);
        $this->doctrine->getManager()->flush();
        return $meeting;
    }

    public function getById($id){
        return $this->doctrine->getRepository('AppBundle:Meeting')
        ->find($id);
    }
}
