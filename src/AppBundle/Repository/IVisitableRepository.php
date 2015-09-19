<?php

namespace AppBundle\Repository;

interface IVisitableRepository {

    public function accept(IVisitor $v);

}