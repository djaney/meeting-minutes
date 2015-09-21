<?php
namespace AppBundle\ApiController;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
abstract class BaseApiController extends FOSRestController implements ClassResourceInterface{
    public function createValidationErrorResponse($errors){
        $arr = [];
        foreach($errors as $e){
            $arr[] = ['field'=>$e->getPropertyPath(),'message'=>$e->getMessage()];
        }

        $responseString = $this->get('serializer')->serialize(['errors'=>$arr],'json');
        $res = new JsonResponse();
        $res->setContent($responseString);
        $res->setStatusCode(400);
        return $res;
    }
}
