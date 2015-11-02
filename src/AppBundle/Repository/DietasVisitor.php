<?php

namespace AppBundle\Repository;

use AppBundle\Entity\CondicionesDeSalud as Condicion;
use AppBundle\Entity\Dieta as Dieta;
use AppBundle\Constants\EnfermedadesConstants as Enfermedades;
use AppBundle\Entity\CondicionesDeSalud;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Proxies\__CG__\AppBundle\Entity\GruposAlimenticios;

class DietasVisitor implements IVisitor {

    public function visit (IVisitableRepository $repository){

        $user = $repository->user;
        $qb = $repository->qb;
        $em = $repository->em;

        $dieta = $user->getDieta();

        if(!$dieta) return $qb;

        $qb = $this->addFilter($qb, $em, $dieta);

        return $qb;

    }

    private function addFilter(QueryBuilder $qb, EntityManager $em, Dieta $dieta ){

        $qb_aux = $em->createQueryBuilder();

        $d = $qb_aux  ->select("d")
            ->from("AppBundle:Dieta", "d")
            ->where($qb_aux->expr()->eq("d.nombre", ":nombre"))
            ->setParameter("nombre", $dieta->getNombre())
            ->getQuery()->getResult();

        $d = $d[0];

        $grupos = $qb_aux ->select("g")
            ->from("AppBundle:GruposAlimenticios", "g")
            ->getQuery()->getResult();

        $grupos_prohibidos_ids = array();
        $i = 0;
        foreach ($grupos as $g) {
            $dietas = $g->getIdDieta()->toArray();
            if (in_array($d, $dietas)){
                $grupos_prohibidos_ids[] = $g->getId();
            }
            $i++;
        }

        foreach($grupos_prohibidos_ids as $p)
            $qb ->andWhere($qb->expr()->neq("r.grupoAlim", $p));

        return $qb;

    }


}