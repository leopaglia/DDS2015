<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;

use AppBundle\Entity\Usuario;
use AppBundle\Entity\CondicionesDeSalud;
use AppBundle\Entity\Rutina;

class RecetasController extends BasicController{

	/**
     * @Route("/seleccionarRecetas", name="seleccionarRecetas")
     */
    public function seleccionarRecetasAction(){
    	
	    return $this->render('Default/seleccionarRecetas.html.twig', array("title" => "Seleccionar Recetas"));
    }
    
    

}
