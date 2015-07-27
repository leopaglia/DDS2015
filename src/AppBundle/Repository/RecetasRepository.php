<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Usuario as User;

class RecetasRepository extends EntityRepository{

    /**
     * @param mixed $arrayFiltros
     * @param User $ignoredUser
     * @param int $offset
     * @param int $limit
     * @param bool $hydrateArray
     * @return array
     */
    public function getRecetas ($arrayFiltros, $ignoredUser = null, $offset=0, $limit=0, $hydrateArray = false)
    {

        $qb = $this->buildQuery($arrayFiltros, $ignoredUser);

        if ($offset != 0 || $limit != 0){
            $qb->setFirstResult($offset)->setMaxResults($limit);
        }

        return $hydrateArray ? $qb->getQuery()->getArrayResult() : $qb->getQuery()->getResult();
    }

    /**
     * @param $filtros
     * @param User $ignoredUser
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function buildQuery($filtros, $ignoredUser){

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb ->select("r")
            ->from("AppBundle:Receta", "r")
            ->orderBy("r.nombre")
        ;

        $filtros = $this->trimFilters($filtros);

        if ($this->validFilter($filtros['ingrediente'])){

            $qb ->join("r.idingrediente", "i")
                ->andWhere($qb->expr()->like("i.nombre", ":nombre"))
                ->setParameter("nombre", $this->wildcard($filtros['ingrediente']));

        }

        if ($this->validFilter($filtros['temporada'])){

            $qb ->andWhere($qb->expr()->eq("r.temporada", ":temporadaId"))
                ->setParameter("temporadaId", $filtros['temporada']);

        }

        if ($this->validFilter($filtros['dificultad'])){

            $qb ->andWhere($qb->expr()->eq("r.dificultad", ":dificultad"))
                ->setParameter("dificultad", $filtros['dificultad']);

        }

        if ($this->validFilter($filtros['caloriasDesde'])){

            $qb ->andWhere($qb->expr()->gte("r.calorias", ":caloriasDesde"))
                ->setParameter("caloriasDesde", $filtros['caloriasDesde']);

        }

        if ($this->validFilter($filtros['caloriasHasta'])){

            $qb ->andWhere($qb->expr()->lte("r.calorias", ":caloriasHasta"))
                ->setParameter("caloriasHasta", $filtros['caloriasHasta']);

        }

        //Para que no traiga las recetas que ya tiene en el perfil
        if($ignoredUser != null){

            $arrayRecetas = $ignoredUser->getIdreceta()->toArray();

            foreach($arrayRecetas as $receta){
                $qb ->andWhere($qb->expr()->neq("r.id", ":idAIgnorar"))
                    ->setParameter("idAIgnorar", $receta->getId());
            }

        }

        return $qb;
    }

    private function validFilter($filter){

        return !empty($filter) && trim($filter) != "";

    }

    private function trimFilters($filters){

        $trimmedFilters = array();

        foreach($filters as $key => $value){
            $trimmedFilters[$key] = trim($value);
        }

        return $trimmedFilters;

    }

    private function wildcard($string){

        return '%'.$string.'%';

    }

}

