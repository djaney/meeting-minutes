<?php
namespace AppBundle\Facade;
abstract class BaseFacade {

    protected $doctrine;
    protected $subject = null;
    protected $em = null;
    protected $className = null;

    public function __construct($doctrine){
        $this->doctrine = $doctrine;
        $this->em = $this->doctrine->getManager();
    }

    public function getById($id){
        return $this->doctrine->getRepository($this->className)
        ->find($id);
    }
    public function setSubject($subject){
        $this->subject = $subject;
        return $this;
    }
    public function setSubjectById($id){
        return $this->setSubject($this->getById($id));
    }
    public function getSubject(){
        return $this->subject;
    }
    public function clean(){
        $this->subject = null;
        return $this;
    }
    public function flush(){
        $this->em->flush();
        return $this->clean();
    }

    public function create(){

        $r = new \ReflectionClass($this->className);
        $meeting = $r->newInstanceArgs();
        $this->em->persist($meeting);
        $this->em->flush();
        $this->setSubject($meeting);
        return $this;
    }

    public function mutate(\Closure $callback){
        if($this->subject===null) throw new InvalidFacadeSubjectException();
        $callback($this->subject);
        return $this;
    }
    public function patch($array){
        if($this->subject===null) throw new InvalidFacadeSubjectException();
        $r = new \ReflectionClass($this->subject);
        foreach($array as $k=>$v){
            if( $k=='id' ) continue;
            $method = 'set' . ucfirst($k) ;
            if( $r->hasMethod( $method ) ){
                $this->subject->$method($v);
            }
        }
        return $this;
    }

}
