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

class UserController extends BasicController{

	/**
     * @Route("/perfil", name="profile")
     */
    public function profileAction(){
    	
    	$complexiones = $this->getDoctrine()->getRepository("AppBundle:Complexion")->findAll();
    	$condiciones = $this->getDoctrine()->getRepository("AppBundle:CondicionesDeSalud")->findAll();
    	
    	$arrayComplexiones = array();
    	$arrayCondiciones = array();
    	
    	foreach ($complexiones as $c){
    		$arrayComplexiones[] = array("name" => $c->getNombre(), "value" => $c->getId());
    	}
    	foreach ($condiciones as $c){
    		$arrayCondiciones[] = array("name" => $c->getNombre(), "value" => $c->getId());
    	}
    	
    	$fields = array(
    			array("label" => "Altura", "type" => "input", "idName" => "altura", "placeholder" => "Ingrese su Altura (en centimetros)"),
    			array("label" => "Complexion", "type" => "select", "idName" => "complexion", "options" => $arrayComplexiones),
    			array("label" => "Condiciones preexistentes", "type" => "select", "idName" => "condiciones", "options" => $arrayCondiciones),
    	);	
    	
    	$buttons = array(
    			array("type" => "submit", "text" => "Guardar")
    	);
    	
    	$options = array(
    			"routename" => "updateProfile",
    	);
    	
    	
	    return $this->renderBasicForm($fields, $buttons, $options, "Modificar perfil");
    }
    
    
    /**
     * @Route("/actualizarPerfil", name="updateProfile")
     */
    public function updateProfileAction(Request $request){
    	
    	//TODO cambiar condicionesdesalud a many to many
    	
    	$em = $this->getDoctrine()->getManager();
    	
    	$dni = $this->getUser();
    	$user = $this->getDoctrine()->getRepository("AppBundle:Usuario")->find($dni);
    	
    	$altura = $request->request->get("altura");
    	$complexion = $request->request->get("complexion");
    	$condicion = $request->request->get("condiciones"); 
    	
    	$user->setAltura($altura);
    	$user->setCondicion($this->getDoctrine()->getRepository("AppBundle:CondicionesDeSalud")->find($condicion));
    	$user->setComplexion($this->getDoctrine()->getRepository("AppBundle:Complexion")->find($complexion));
    	
    	$em->persist($user);
    	$em->flush();
    	
    	return new RedirectResponse($this->generateUrl("homepage"));
    	
    }

}
