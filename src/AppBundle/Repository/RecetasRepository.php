<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\AST\Join;
use Doctrine\ORM\Query\Expr\Join as ExprJoin;
use Doctrine\ORM\Query\Lexer as Lexer;

use AppBundle\Entity\Usuario as User;
use AppBundle\Constants\RangeConstants;
use Symfony\Component\Validator\Constraints\DateTime;

class RecetasRepository extends EntityRepository{

    /**
     * @param mixed $arrayFiltros
     * @param User $ignoredUser
     * @param int $offset
     * @param int $limit
     * @param bool $hydrateArray
     * @return array
     */
    public function getRecetasByFilters ($arrayFiltros, $ignoredUser = null, $offset=0, $limit=0, $hydrateArray = false)
    {

        $qb = $this->buildQueryByFilters($arrayFiltros, $ignoredUser);

        if ($offset != 0 || $limit != 0){
            $qb->setFirstResult($offset)->setMaxResults($limit);
        }

        return $hydrateArray ? $qb->getQuery()->getArrayResult() : $qb->getQuery()->getResult();
    }

    /**
     * @param int $limit
     * @param bool $hydrateArray
     * @return array
     */
    public function getTopRecetas ($limit=0, $hydrateArray = false)
    {
        $qb = $this->buildQueryByMostViews();

        $qb->setMaxResults($limit);

        return $hydrateArray ? $qb->getQuery()->getArrayResult() : $qb->getQuery()->getResult();
    }

    /**
     * @param mixed $filtros
     * @param int $limit
     * @param bool $hydrateArray
     * @return array
     */
    public function getTopRecetasByFilters ($filtros, $limit=0, $hydrateArray = false)
    {
        $qb = $this->buildQueryByMostViews();

        $filtros = $this->trimFilters($filtros);

        $domingoSemana = strtotime('last sunday', strtotime('tomorrow')); //domingo de esta semana (dia 0)
        $primerDiaMes = date('01-m-Y'); //domingo de esta semana (dia 0)

        if ($this->validFilter($filtros['rango'])){

            if($filtros['rango'] == RangeConstants::SEMANA){
                $qb ->andWhere($qb->expr()->gte("h.fecha", ":semana"))
                    ->setParameter("semana",$domingoSemana);
            }

            if($filtros['rango'] == RangeConstants::MES){
                $qb ->andWhere($qb->expr()->gte("h.fecha", ":mes"))
                    ->setParameter("mes", $primerDiaMes);
            }

        }

        if ($this->validFilter($filtros['dificultad'])){

            $qb ->andWhere($qb->expr()->eq("r.dificultad", ":dificultad"))
                ->setParameter("dificultad", $filtros['dificultad']);

        }

        if ($this->validFilter($filtros['sexo'])){

            $qb->innerJoin("AppBundle:Usuario", "u", 'WITH', 'h.idusuario = u.dni');
            $qb ->andWhere($qb->expr()->eq("u.sexo", ":sexo"))
                ->setParameter("sexo", $filtros['sexo']);

        }

        if($limit != 0) $qb->setMaxResults($limit);

        return $hydrateArray ? $qb->getQuery()->getArrayResult() : $qb->getQuery()->getResult();
    }

    /**
     * @param $filtros
     * @param User $ignoredUser
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function buildQueryByFilters($filtros, $ignoredUser){

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

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function buildQueryByMostViews (){

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb ->select("r, COUNT(h.id) AS views")
            ->from("AppBundle:Historial", "h")
            ->innerJoin("AppBundle:Receta", "r", 'WITH', 'h.idreceta = r.id')
            ->groupBy("r.nombre")
            ->orderBy("views", "DESC");
        ;

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

