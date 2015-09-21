<?php
namespace AppBundle\Facade;
use AppBundle\Entity\Meeting;
use AppBundle\Entity\MeetingMinutes;
class MeetingFacade implements FacadeInterface {
    private $doctrine;
    private $meeting = null;
    public function __construct($doctrine){
        $this->doctrine = $doctrine;
    }
    public function setSubject($meeting){
        $this->meeting = $meeting;
        return $this;
    }
    public function clean(){
        $this->meeting = null;
        return $this;
    }
    public function create($name = ''){
        $meeting = new Meeting();
        $meeting->setName($name);
        $this->doctrine->getManager()->persist($meeting);
        $this->doctrine->getManager()->flush();
        $this->setSubject($meeting);
        return $this;
    }

    public function getSubject(){
        return $this->meeting;
    }

    public function getById($id){
        return $this->doctrine->getRepository('AppBundle:Meeting')
        ->find($id);
    }

    public function setSubjectById($id){
        $this->meeting = $this->getById($id);
        return $this;
    }
    public function addMinute($name,$description = ''){
        if($this->meeting===null) throw new InvalidFacadeSubjectException();
        $min = new MeetingMinutes();
        $min->setName($name);
        $min->setDescription($description);
        $this->meeting->addMinute($min);
        return $this;
    }
}
