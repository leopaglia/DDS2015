<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

use AppBundle\Entity\Usuario;
use AppBundle\Entity\Receta;

class RecetasController extends BasicController{

	/**
     * @Route("/seleccionarRecetas", name="seleccionarRecetas")
     */
    public function seleccionarRecetasAction(){
    	
	    return $this->render('Default/seleccionarRecetas.html.twig', array("title" => "Seleccionar Recetas"));
    }
    
    
    /**
     * @Route("/buscarRecetas", name="buscarRecetas")
     */
    public function buscarRecetasAction(){
    	
    	$recetas = $this->getDoctrine()->getRepository('AppBundle:Receta')->findAll();
    	
		$arrayRecetas = array();
		
		foreach($recetas as $receta){
			
			$arrayReceta = array();
			
			$url = $this->generateUrl('verReceta', array('id' => $receta->getId()));
			$arrayReceta["nombre"] = '<a href="'.$url.'">'.$receta->getNombre().'</a>';
			$arrayReceta["temporada"] = $receta->getTemporada()->getNombre();
			$arrayReceta["dificultad"] = $receta->getDificultad();
			$arrayReceta["calorias"] = "muchas";
			$arrayReceta["calificacion"] = $receta->getCalificacion();
			
			$arrayRecetas[] = $arrayReceta;
		}
    	
    	return new JsonResponse($arrayRecetas);
    }
    
    /**
     * @Route("/verReceta/{id}", name="verReceta")
     */
    public function verRecetaAction($id){
    	 
    	$receta = $this->getDoctrine()->getRepository('AppBundle:Receta')->find($id);
    	 
    	$arrayReceta = array();
    			
    	$arrayReceta["nombre"] = $receta->getNombre();
    	$arrayReceta["temporada"] = $receta->getTemporada()->getNombre();
    	$arrayReceta["dificultad"] = $receta->getDificultad();
    	$arrayReceta["calorias"] = "muchas";
    	$arrayReceta["calificacion"] = $receta->getCalificacion();	
    	 
    	return $this->render("default/receta.html.twig", $arrayReceta);
    }
    
    /**
     * @Route("/cargarReceta", name="generateRecipe")
     */
    public function generarRecetaAction(){
    	
    	//datos
    	
    	$arrayDificultades = array();
    	$arrayTemporadas = array();
    	$arrayIngredientes = array();
    	$arrayCondimentos = array();
    	$arrayClasificaciones = array();
    	
    	//vista
    	
		$fieldsets = array(
     		
     			array("title" => "Tipo de receta", "fields" => array(
     					array("label" => "Nombre", "type" => "input", "idName" => "nombre", "placeholder" => "Ingrese nombre"),
     					array("label" => "Dificultad", "type" => "select", "idName" => "dificultad", "options" => $arrayDificultades),
     					array("label" => "Temporada", "type" => "select", "idName" => "temporada", "options" => $arrayTemporadas),
     			)),
				
				array("title" => "Clasificacion", "fields" => array(
						array("label" => "Clasificacion", "type" => "multiselect", "idName" => "clasificacion", "options" => $arrayClasificaciones),
				)),
     					
     			array("title" => "Ingredientes", "fields" => array(
     					array("label" => "Ingredientes", "type" => "multiselect", "idName" => "ingredientes", "options" => $arrayIngredientes),
     			)),
				
				array("title" => "Condimentos", "fields" => array(
						array("label" => "Condimentos", "type" => "multiselect", "idName" => "condimentos", "options" => $arrayCondimentos),
				)),

     			
     	);	
    	
    	$buttons = array(
    			array("type" => "submit", "text" => "Guardar")
    	);
    	
    	$config = array(
    			"display"   => "accordion",
    			"routename" => "saveRecipe",
    	);
    	 
    	return $this->renderBasicForm($fieldsets, $buttons, $config, "Crear nueva receta");
    }
    
    
    /**
     * @Route("/guardarReceta", name="saveRecipe")
     */
    public function guardarRecetaAction(Request $request){
    	
    	$em = $this->getDoctrine()->getManager();
    	 
    	$dni = $this->getUser();
    	$user = $this->getDoctrine()->getRepository("AppBundle:Usuario")->find($dni);
    	
    	$receta = new Receta();
    	 
    	$nombre = $request->request->get("nombre");
    	$dificultad = $request->request->get("dificultad");
    	$temporada = $request->request->get("temporada");
    	$clasificacion = $request->request->get("clasificacion");
    	$ingredientes = $request->request->get("ingredientes");
    	$condimentos = $request->request->get("condimentos");
    	 
    	$em->beginTransaction();
    	 
    	try{
    	
    		if(!empty($nombre))
    			$receta->setNombre($nombre);
    		if(!empty($dificultad))
    			$receta->setApellido($dificultad);
    		if(!empty($temporada))
    			$receta->setEdad($temporada);
    		if(!empty($clasificacion))
    			$receta->setAltura($clasificacion);
    		if(!empty($ingredientes))
    			$receta->setRutina($ingredientes);
    		if(!empty($condimentos))
    			$receta->setComplexion($this->getDoctrine()->getRepository("AppBundle:Complexion")->find($condimentos));
//     		if(!empty($condiciones))
//     			foreach($condiciones as $condicion)
//     				$receta->addCondicion($this->getDoctrine()->getRepository("AppBundle:CondicionesDeSalud")->find($condicion[0]));
    			 
    		$em->persist($receta);
    		$em->flush();
    		
    		//$user->addReceta($receta); //TODO testear
    		
    		$em->persist($user);
    		$em->flush();
    			 
    	}catch(exception $e){
    		$em->rollback();
    		throw($e);
    	}
    	 
    	$em->commit();
    	 
    	return new Response($this->generateUrl("homepage"));
    }
    

}
