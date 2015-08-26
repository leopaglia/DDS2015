<?php

namespace AppBundle\Repository;

interface IVisitableRepository {

    public function accept(EnfermedadesVisitor $v);

}