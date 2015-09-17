<?php
namespace AppBundle\Factories;
use AppBundle\Entity\Meeting;
class MeetingFactory {
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
}
