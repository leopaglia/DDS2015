<?php

namespace AppBundle\Repository;

class GenericRepository{

    private $entity;
    private $doctrine;

    private static $instance = null;

    private function __construct($entity, $doctrine){
        $this->entity = $entity;
        $this->doctrine = $doctrine;
    }

    public static function getInstance($entity, $doctrine){

        if(self::$instance == null){
            self::$instance = new GenericRepository($entity, $doctrine);
        }
        else{
            self::$instance->$entity = $entity;
        }

        return self::$instance;
    }

    public function idExists($id){
        return ($this->doctrine->getRepository($this->entity)->find($id) != null);
    }


}