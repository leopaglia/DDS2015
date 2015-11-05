<?php

namespace AppBundle\Repository;

use AppBundle\Constants\ReportConstants;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\AST\Join;
use Doctrine\ORM\Query\Expr\Join as ExprJoin;
use Doctrine\ORM\Query\Lexer as Lexer;

use AppBundle\Entity\Usuario as User;
use AppBundle\Constants\RangeConstants;
use Proxies\__CG__\AppBundle\Entity\Usuario;
use Symfony\Component\Validator\Constraints\DateTime;


class RecetasRepository extends EntityRepository implements IVisitableRepository{

    public $user;
    public $qb;
    public $em;

    /**
     * @param mixed $arrayFiltros
     * @param User $user
     * @param int $offset
     * @param int $limit
     * @param bool $hydrateArray
     * @return array
     */
    public function getRecetasByFilters ($arrayFiltros, $user, $acceptVisitors = true, $offset=0, $limit=0, $hydrateArray = false){

        $this->user = $user;
        $this->em = $this->getEntityManager();

        //el 2do parametro hace que ignore o no las recetas que el usuario ya tiene en el perfil
        $this->qb = $this->buildQueryByFilters($arrayFiltros, false);

        if ($offset != 0 || $limit != 0){
            $this->qb->setFirstResult($offset)->setMaxResults($limit);
        }

        if ($acceptVisitors){
            $enfermedadesVisitor = new EnfermedadesVisitor();
            $this->qb = $this->accept($enfermedadesVisitor); //agrega filtros segun las enfermedades del usuario

            $dietasVisitor = new DietasVisitor();
            $this->qb = $this->accept($dietasVisitor); //agrega filtros segun las dietas del usuario
        }

        return $hydrateArray ? $this->qb->getQuery()->getArrayResult() : $this->qb->getQuery()->getResult();
    }

    public function accept (IVisitor $visitor){
        return $visitor->visit($this);
    }

    /**
     * @param User $user
     * @param mixed $arrayFiltros
     * @param int $offset
     * @param int $limit
     * @param bool $hydrateArray
     * @return array
     */
    public function getRecetasForReport ($user, $arrayFiltros, $offset=0, $limit=0, $hydrateArray = false){

        $qb = $this->buildQueryForReport($arrayFiltros, $user);

        if ($offset != 0 || $limit != 0){
            $qb->setFirstResult($offset)->setMaxResults($limit);
        }

        return $hydrateArray ? $qb->getQuery()->getArrayResult() : $qb->getQuery()->getResult();
    }

    /**
     * @param User $user
     * @param mixed $arrayFiltros
     * @param int $offset
     * @param int $limit
     * @param bool $hydrateArray
     * @return array
     */
    public function getRecomendaciones ($usuario, $offset=0, $limit=0, $hydrateArray = false){

        $qb = $this->buildQueryRecomendaciones($usuario);

        if ($offset != 0 || $limit != 0){
            $qb->setFirstResult($offset)->setMaxResults($limit);
        }

        return $hydrateArray ? $qb->getQuery()->getArrayResult() : $qb->getQuery()->getResult();
    }


    /**
     * @param mixed $filtros
     * @param int $limit
     * @param bool $hydrateArray
     * @return array
     */
    public function getTopRecetas ($limit = 0, $filtros = null, $hydrateArray = false){

        $qb = $this->buildQueryByMostViews();

        if($filtros != null){

            $filtros = $this->trimFilters($filtros);

            if ($this->validFilter($filtros['rango'])){

                $domingoSemana = strtotime('last sunday', strtotime('tomorrow')); //domingo de esta semana (dia 0)
                $primerDiaMes = date('01-m-Y');

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

        }

        if($limit != 0) $qb->setMaxResults($limit);

        return $hydrateArray ? $qb->getQuery()->getArrayResult() : $qb->getQuery()->getResult();
    }

    /**
     * @param $filtros
     * @param Boolean $ignoreUser
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function buildQueryByFilters($filtros, $ignoreUser){

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb ->select("r")
            ->from("AppBundle:Receta", "r")
            ->orderBy("r.nombre")
        ;

        $filtros = $this->trimFilters($filtros);

        if ($this->validFilter($filtros['nombre'])){

            $qb ->andWhere($qb->expr()->like("r.nombre", ":nombre"))
                ->setParameter("nombre", $this->wildcard($filtros['nombre']));

        }

        if ($this->validFilter($filtros['temporada'])){

            $qb ->andWhere($qb->expr()->eq("r.temporada", ":temporadaId"))
                ->setParameter("temporadaId", $filtros['temporada']);

        }

        if ($this->validFilter($filtros['dificultad'])){

            $qb ->andWhere($qb->expr()->eq("r.dificultad", ":dificultad"))
                ->setParameter("dificultad", $filtros['dificultad']);

        }

        if ($this->validFilter($filtros['clasificacion'])){ //FIXME

            //$qb->innerJoin("r.idClasificacion c ON c.id = r.idClasificacion");

            //$qb ->andWhere($qb->expr()->eq("r.idClasificacion", ":idClasificacion"))
            //    ->setParameter("idClasificacion", $filtros['clasificacion']);

        }

        if ($this->validFilter($filtros['grupoAlimenticio'])){

            $qb ->andWhere($qb->expr()->eq("r.grupoAlim", ":grupoAlim"))
                ->setParameter("grupoAlim", $filtros['grupoAlimenticio']);

        }

        if ($this->validFilter($filtros['owner'])){

            if($filtros['owner'] == "me"){
                $qb ->andWhere($qb->expr()->eq("r.idUsuario", ":idusuario"))
                    ->setParameter("idusuario", $this->user->getId());
            }

        }


        if($ignoreUser){

            $arrayRecetas = $this->user->getIdreceta()->toArray();

            foreach($arrayRecetas as $receta){
                $qb ->andWhere($qb->expr()->neq("r.id", ":idAIgnorar"))
                    ->setParameter("idAIgnorar", $receta->getId());
            }

        }

        return $qb;
    }

    /**
     * @param $filtros
     * @param User $user
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function buildQueryForReport($filtros, $user){

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb ->select("r")
            ->from("AppBundle:Receta", "r")
            ->innerJoin("AppBundle:Historial", "h", 'WITH', 'h.idreceta = r.id')
            ->andWhere($qb->expr()->eq("h.idusuario", ":id"))
            ->setParameter("id", $user->getId())
            ->orderBy("r.nombre")
        ;

        $filtros = $this->trimFilters($filtros);

        if ($this->validFilter($filtros['tipoReporte'])){

            if($filtros['tipoReporte'] == ReportConstants::CONSULTADAS){
                $qb->andWhere($qb->expr()->eq("h.aceptada", '0'));
            }

            if($filtros['tipoReporte'] == ReportConstants::PREFERIDAS){
                $qb->andWhere($qb->expr()->eq("h.aceptada", '1'));
            }

            if($filtros['tipoReporte'] == ReportConstants::PROPUESTAS){
                $qb->andWhere($qb->expr()->eq("r.idUsuario", ":id"));
                $qb->setParameter("id", $user->getId());
            }

        }

        if ($this->validFilter($filtros['fechaDesde'])){

            $qb ->andWhere($qb->expr()->gte("h.fecha", ":fechaDesde"))
                ->setParameter("fechaDesde", $filtros['fechaDesde']);

        }

        if ($this->validFilter($filtros['fechaHasta'])){

            $qb ->andWhere($qb->expr()->lte("h.fecha", ":fechaHasta"))
                ->setParameter("fechaHasta", $filtros['fechaHasta']);

        }

        return $qb;
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    private function buildQueryRecomendaciones (\AppBundle\Entity\Usuario $user){

        //ultimas 10 recetas aceptadas
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb ->select("r")
            ->from("AppBundle:Historial", "h")
            ->innerJoin("AppBundle:Receta", "r", 'WITH', 'h.idreceta = r.id')
            ->where('h.aceptada = 1')
            ->andWhere('h.idusuario = :id')
            ->setParameter("id", $user->getId())
            ->orderBy("h.fecha")
            ->setMaxResults(10);
        ;
        if($qb->getQuery()->getResult())
            return $qb;


        //ultimas 10 recetas calificadas
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb ->select("r")
            ->from("AppBundle:Historial", "h")
            ->innerJoin("AppBundle:Receta", "r", 'WITH', 'h.idreceta = r.id')
            ->where('h.aceptada = 2')
            ->andWhere('h.idusuario = :id')
            ->setParameter("id", $user->getId())
            ->orderBy("h.fecha")
            ->setMaxResults(10);
        ;
        if($qb->getQuery()->getResult())
            return $qb;


        //ultimas 10 recetas miradas
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb ->select("r")
            ->from("AppBundle:Historial", "h")
            ->innerJoin("AppBundle:Receta", "r", 'WITH', 'h.idreceta = r.id')
            ->where('h.aceptada = 0')
            ->andWhere('h.idusuario = :id')
            ->setParameter("id", $user->getId())
            ->orderBy("h.fecha")
            ->setMaxResults(10);
        ;
        if($qb->getQuery()->getResult())
            return $qb;


        //10 mejores calificadas
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb ->select("r")
            ->from("AppBundle:Receta", "r")
            ->orderBy("r.calificacion")
            ->setMaxResults(10);

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
            ->where('h.aceptada = 0') //cuenta solo visitas
            ->groupBy("r.nombre")
            ->orderBy("views", "DESC");
        ;

        return $qb;
    }

    private function validFilter($filter){

        return $filter != null && !empty($filter) && trim($filter) != "";

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

