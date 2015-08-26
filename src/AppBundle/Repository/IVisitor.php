<?php

namespace AppBundle\Repository;

interface IVisitor {

    public function visit(IVisitableRepository $repository);

}