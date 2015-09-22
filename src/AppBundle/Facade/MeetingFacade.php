<?php
namespace AppBundle\Facade;
use AppBundle\Entity\Meeting;
use AppBundle\Entity\MeetingMinutes;
class MeetingFacade extends BaseFacade {



    protected $className = 'AppBundle\Entity\Meeting';

    public function addMinute(MeetingMinutes $minute){
        if($this->subject===null) throw new InvalidFacadeSubjectException();
        $this->subject->addMinute($minute);
        return $this;
    }
}
