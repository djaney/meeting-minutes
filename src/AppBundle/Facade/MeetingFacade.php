<?php
namespace AppBundle\Facade;
use AppBundle\Entity\Meeting;
use AppBundle\Entity\MeetingMinutes;
class MeetingFacade extends BaseFacade {



    protected $className = 'AppBundle\Entity\Meeting';

    public function addMinute($name,$description = ''){
        if($this->subject===null) throw new InvalidFacadeSubjectException();
        $min = new MeetingMinutes();
        $min->setName($name);
        $min->setDescription($description);
        $min->setMeeting($this->subject);
        $this->subject->addMinute($min);
        return $this;
    }
}
