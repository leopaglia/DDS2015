<?php

namespace AppBundle\Repository;

use AppBundle\Entity\CondicionesDeSalud as Condicion;
use AppBundle\Constants\EnfermedadesConstants as Enfermedades;
use AppBundle\Entity\CondicionesDeSalud;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Proxies\__CG__\AppBundle\Entity\GruposAlimenticios;

class EnfermedadesVisitor implements IVisitor {

    public function visit (IVisitableRepository $repository){

        $user = $repository->user;
        $qb = $repository->qb;
        $em = $repository->em;

        foreach($user->getIdcondiciones()->getValues() as $enfermedad)
            $qb = $this->addFilter($qb, $em, $enfermedad);

        return $qb;

    }

    private function addFilter(QueryBuilder $qb, EntityManager $em, Condicion $enfermedad ){

        $qb_aux = $em->createQueryBuilder();

        $condicion = $qb_aux  ->select("c")
            ->from("AppBundle:CondicionesDeSalud", "c")
            ->where($qb_aux->expr()->eq("c.nombre", ":nombre"))
            ->setParameter("nombre", $enfermedad->getNombre())
            ->getQuery()->getResult();

        $condicion = $condicion[0];

        $grupos = $qb_aux ->select("g")
            ->from("AppBundle:GruposAlimenticios", "g")
            ->getQuery()->getResult();

        $grupos_prohibidos_ids = array();
        $i = 0;
        foreach ($grupos as $g) {
            $condiciones = $g->getIdCondicion()->toArray();
            if (in_array($condicion, $condiciones)){
                $grupos_prohibidos_ids[] = $g->getId();
            }
            $i++;
        }

        foreach($grupos_prohibidos_ids as $p)
            $qb ->andWhere($qb->expr()->neq("r.grupoAlim", $p));

        return $qb;

    }


}