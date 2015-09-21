<?php

namespace AppBundle\ApiController;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;

class MeetingController extends BaseApiController
{
    public function getAction($id){
        $meeting = $this->get('facade.meeting')->getById($id);
        return $meeting;
    }

    public function postAction(Request $req){
        $request = $req->request;
        $meeting = $this->get('facade.meeting')
            ->create()
            ->mutate(function($subject) use ($request){
                $r = new \ReflectionClass($subject);
                foreach($request->all() as $k=>$v){
                    if( $k=='id' ) continue;
                    $method = 'set' . ucfirst($k) ;
                    if( $r->hasMethod( $method ) ){
                        $subject->$method($v);
                    }
                }
            })
            ->getSubject()

        ;


        $validator = $this->get('validator');
        $errors = $validator->validate($meeting);
        if ($errors->count() > 0) {
            return $this->createValidationErrorResponse($errors);
        }

        $this->get('facade.meeting')->flush();
        return $meeting;
    }

    public function patchAction($id,Request $req){
        $request = $req->request;
        $meeting = $this->get('facade.meeting')
            ->setSubjectById($id)
            ->mutate(function($subject) use ($request){
                $r = new \ReflectionClass($subject);
                foreach($request->all() as $k=>$v){
                    if( $k=='id' ) continue;
                    $method = 'set' . ucfirst($k) ;
                    if( $r->hasMethod( $method ) ){
                        $subject->$method($v);
                    }
                }
            })->getSubject();

            $validator = $this->get('validator');
            $errors = $validator->validate($meeting);
            if ($errors->count() > 0) {
                return $this->createValidationErrorResponse($errors);
            }

            $this->get('facade.meeting')->flush();
            return $meeting;
    }
}
