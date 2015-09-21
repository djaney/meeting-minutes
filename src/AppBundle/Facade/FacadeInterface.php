<?php
namespace AppBundle\Facade;
interface FacadeInterface {
    public function setSubject($subject);
    public function getById($id);
    public function setSubjectById($id);
    public function getSubject();
    public function clean();
}
