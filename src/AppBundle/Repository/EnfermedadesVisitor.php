<?php

namespace AppBundle\Repository;

use AppBundle\Entity\CondicionesDeSalud as Condicion;
use AppBundle\Constants\EnfermedadesConstants as Enfermedades;

class EnfermedadesVisitor implements IVisitor {

    public function visit (IVisitableRepository $repository){

        $user = $repository->user;
        $qb = $repository->qb;

        foreach($user->getIdcondiciones()->getValues() as $enfermedad){

            $qb = $this->addFilter($qb, $enfermedad);

        }

        return $qb;

    }

    private function addFilter($qb, Condicion $condicion ){

        $name = $condicion->getNombre();

        if($name == Enfermedades::DIABETES){
            $qb = $this->addDiabetesFilter($qb);
        }

        if($name == Enfermedades::CELIASIS){
            $qb = $this->addCeliasisFilter($qb);
        }

        if($name == Enfermedades::HIPERTENSION){
            $qb = $this->addHipertensionFilter($qb);
        }

        return $qb;

    }

    private function addDiabetesFilter($qb){

        return $qb;
    }

    private function addCeliasisFilter($qb){

        return $qb;
    }

    private function addHipertensionFilter($qb){

        return $qb;
    }


}