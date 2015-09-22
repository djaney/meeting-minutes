<?php

namespace AppBundle\ApiController;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
class MinutesController extends BaseApiController
{
    public function cgetAction($meetingId,Request $req){
    }

    public function getAction($meetingId,$id,Request $req){
    }

    public function postAction($meetingId,Request $req){
        $minute = $this->get('facade.minutes')
            ->create()
            ->patch($req->request->all())->getSubject();
        $validator = $this->get('validator');
        $errors = $validator->validate($minute);
        if ($errors->count() > 0) {
            return $this->createValidationErrorResponse($errors);
        }

        $this->get('facade.meeting')
        ->setSubjectById($meetingId)
        ->addMinute($minute)->flush();
        return $minute;
    }

    public function patchAction($meetingId,$id,Request $req){
        $minute = $this->get('facade.minutes')
            ->setSubjectById($id)
            ->patch($req->request->all())->getSubject();

            $validator = $this->get('validator');
            $errors = $validator->validate($minute);
            if ($errors->count() > 0) {
                return $this->createValidationErrorResponse($errors);
            }
        $this->get('facade.minutes')->flush();

        return $minute;
    }
}
