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

class UserController extends BasicController{

	/**
     * @Route("/perfil", name="profile")
     */
    public function profileAction(){
    	
    	//Datos
    	
    	$complexiones = $this->getDoctrine()->getRepository("AppBundle:Complexion")->findAll();
     	$condiciones = $this->getDoctrine()->getRepository("AppBundle:CondicionesDeSalud")->findAll();
     	$rutinas = $this->getDoctrine()->getRepository("AppBundle:Rutina")->findAll();
    	
    	$arrayComplexiones = array();
     	$arrayCondiciones = array();
     	$arrayRutinas = array();
    	
    	foreach ($complexiones as $c){
    		$arrayComplexiones[] = array("name" => $c->getNombre(), "value" => $c->getId());
    	}
     	foreach ($condiciones as $c){
     		$arrayCondiciones[] = array("name" => $c->getNombre(), "value" => $c->getId());
     	}
     	foreach ($rutinas as $r){
     		$arrayRutinas[] = array("name" => $r->getNombre(), "value" => $r->getId());
     	}

     	//Vista
     	
     	$fieldsets = array(
     		
     			array("title" => "Detalle de Usuario", "fields" => array(
     					array("label" => "Nombre", "type" => "input", "idName" => "nombre", "placeholder" => "Ingrese su Nombre"),
     					array("label" => "Apellido", "type" => "input", "idName" => "apellido", "placeholder" => "Ingrese su Apellido"),
     					array("label" => "Edad", "type" => "input", "idName" => "edad", "placeholder" => "Ingrese su Edad"),
     					array("label" => "Altura", "type" => "input", "idName" => "altura", "placeholder" => "Ingrese su Altura (en centimetros)"),
     					array("label" => "Rutina", "type" => "select", "idName" => "rutina", "options" => $arrayRutinas)
     			)),
     					
     			array("title" => "Complexion", "fields" => array(
     					array("label" => "Complexion", "type" => "select", "idName" => "complexion", "options" => $arrayComplexiones),
     			)),
     			
     			array("title" => "Condiciones Preexistentes", "fields" => array(
     					array("label" => "Condiciones preexistentes", "type" => "multiselect", "idName" => "condiciones", "options" => $arrayCondiciones),
     			)),

     			
     	);	
    	
    	$buttons = array(
    			array("type" => "submit", "text" => "Guardar")
    	);
    	
    	$config = array(
    			"display"   => "accordion",
    			"routename" => "updateProfile",
    	);
    	
    	
	    return $this->renderBasicForm($fieldsets, $buttons, $config, "Modificar perfil");
    }
    
    
    
    /**
     * @Route("/actualizarPerfil", name="updateProfile")
     */
    public function updateProfileAction(Request $request){
    	//TODO terminar
//     	$em = $this->getDoctrine()->getManager();
    	
//     	$dni = $this->getUser();
//     	$user = $this->getDoctrine()->getRepository("AppBundle:Usuario")->find($dni);
    	
//     	$altura = $request->request->get("altura");
//     	$complexion = $request->request->get("complexion");
//     	$condicion = $request->request->get("condiciones"); 
    	
//     	$user->setAltura($altura);
//     	$user->setCondicion($this->getDoctrine()->getRepository("AppBundle:CondicionesDeSalud")->find($condicion));
//     	$user->setComplexion($this->getDoctrine()->getRepository("AppBundle:Complexion")->find($complexion));
    	
//     	$em->persist($user);
//     	$em->flush();
    	
    	return new RedirectResponse($this->generateUrl("homepage"));
    	
    }

}
