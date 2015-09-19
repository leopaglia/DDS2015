<?php

namespace AppBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;

use AppBundle\Entity\Usuario;
use AppBundle\Entity\Receta;
use AppBundle\Entity\Historial;

class RecetasController extends BasicController{

	/**
     * @Route("/seleccionarRecetas", name="seleccionarRecetas")
     */
    public function seleccionarRecetasAction(){

        $data = array();
        $data['url'] = array();

        $data['temporadas'] = $this->getDoctrine()->getRepository("AppBundle:Temporada")->findAll();
        $data['dificultades'] = $this->getDoctrine()->getRepository("AppBundle:Dificultad")->findAll();
        $data['url']['agregarAPerfil'] = $this->generateUrl('agregarAPerfil');

	    return $this->render('Default/seleccionarRecetas.html.twig', array("title" => "Seleccionar Recetas", "data" => $data));
    }


    /**
     * @Route("/reportes", name="reports")
     */
    public function reportsAction(Request $request){

        return $this->render('Default/reportes.html.twig', array("title" => "Reportes"));

    }
    

    /**
     * @Route("/buscarRecetas", name="buscarRecetas")
     */
    public function buscarRecetasAction(Request $request){

        $dni = $this->getUser();
        $user = $this->getDoctrine()->getRepository("AppBundle:Usuario")->find($dni);

        $filtros = array();

        $filtros['ingrediente'] = $request->request->get('ingrediente');
        $filtros['temporada'] = $request->request->get('temporada');
        $filtros['dificultad'] = $request->request->get('dificultad');
        $filtros['caloriasDesde'] = $request->request->get('caloriasDesde');
        $filtros['caloriasHasta'] = $request->request->get('caloriasHasta');

    	$recetas = $this->getDoctrine()->getRepository('AppBundle:Receta')->getRecetasByFilters($filtros, $user);
    	
		$arrayRecetas = array();

        if (!empty($recetas)) {

            foreach($recetas as $receta){

                $arrayReceta = array();

                $url = $this->generateUrl('verReceta', array('id' => $receta->getId()));

                $arrayReceta["id"] = $receta->getId();
                $arrayReceta["nombre"] = '<a href="'.$url.'">'.$receta->getNombre().'</a>';
                $arrayReceta["temporada"] = $receta->getTemporada()->getNombre();
                $arrayReceta["dificultad"] = $receta->getDificultad()->getDescripcion();
//                $arrayReceta["calorias"] = $receta->getCalorias(); //TODO
                $arrayReceta["calorias"] = "bocha";
                $arrayReceta["calificacion"] = $receta->getCalificacion();

                $arrayRecetas[] = $arrayReceta;
            }

        }
    	
    	return new JsonResponse($arrayRecetas);
    }

    /**
     * @Route("/generarReporte", name="generarReporte")
     */
    public function generarReporteAction(Request $request){

        $dni = $this->getUser();
        $user = $this->getDoctrine()->getRepository("AppBundle:Usuario")->find($dni);

        $filtros = array();

        $filtros['tipoReporte'] = $request->request->get('tipoReporte');
        $filtros['fechaDesde'] = $request->request->get('fechaDesde');
        $filtros['fechaHasta'] = $request->request->get('fechaHasta');

        $recetas = $this->getDoctrine()->getRepository('AppBundle:Receta')->getRecetasForReport($user, $filtros);

        $arrayRecetas = array();

        if (!empty($recetas)) {

            foreach($recetas as $receta){

                $arrayReceta = array();

                $url = $this->generateUrl('verReceta', array('id' => $receta->getId()));

                $arrayReceta["id"] = $receta->getId();
                $arrayReceta["nombre"] = '<a href="'.$url.'">'.$receta->getNombre().'</a>';
                $arrayReceta["temporada"] = $receta->getTemporada()->getNombre();
                $arrayReceta["dificultad"] = $receta->getDificultad()->getDescripcion();
//                $arrayReceta["calorias"] = $receta->getCalorias(); //TODO
                $arrayReceta["calorias"] = "bocha";
//                $arrayReceta["calificacion"] = $receta->getCalificacion();

                $arrayRecetas[] = $arrayReceta;
            }

        }

        return new JsonResponse($arrayRecetas);
    }

    /**
     * @Route("/verReceta/{id}", name="verReceta")
     */
    public function verRecetaAction($id){

        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('AppBundle:Usuario')->find($this->getUser());
    	$receta = $this->getDoctrine()->getRepository('AppBundle:Receta')->find($id);
    	 
    	$arrayReceta = array();
    			
    	$arrayReceta["nombre"] = $receta->getNombre();
    	$arrayReceta["temporada"] = $receta->getTemporada()->getNombre();
    	$arrayReceta["dificultad"] = $receta->getDificultad();
    	$arrayReceta["calorias"] = "muchas";
    	$arrayReceta["calificacion"] = $receta->getCalificacion();

        $arrayReceta["paso1"] = $receta->getPaso1();
        $arrayReceta["paso2"] = $receta->getPaso2();
        $arrayReceta["paso3"] = $receta->getPaso3();
        $arrayReceta["paso4"] = $receta->getPaso4();
        $arrayReceta["paso5"] = $receta->getPaso5();

        $arrayReceta["foto1"] = $receta->getFoto1();
        $arrayReceta["foto2"] = $receta->getFoto2();
        $arrayReceta["foto3"] = $receta->getFoto3();
        $arrayReceta["foto4"] = $receta->getFoto4();
        $arrayReceta["foto5"] = $receta->getFoto5();

        $historial = new Historial($user, $receta);

        $em->persist($historial);
        $em->flush();
    	 
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

        $dificultades = $this->getDoctrine()->getRepository("AppBundle:Dificultad")->findAll();
        $temporadas = $this->getDoctrine()->getRepository("AppBundle:Temporada")->findAll();

        foreach ($dificultades as $d){
            $arrayDificultades[] = array("name" => $d->getDescripcion(), "value" => $d->getId());
        }
        foreach ($temporadas as $t){
            $arrayTemporadas[] = array("name" => $t->getNombre(), "value" => $t->getId());
        }

    	//vista
    	
		$fieldsets = array(
     		
     			array("title" => "Tipo de receta", "fields" => array(
     					array("label" => "Nombre", "type" => "input", "idName" => "nombre", "placeholder" => "Ingrese nombre"),
     					array("label" => "Dificultad", "type" => "select", "idName" => "dificultad", "options" => $arrayDificultades),
     					array("label" => "Temporada", "type" => "select", "idName" => "temporada", "options" => $arrayTemporadas),
     			)),
				
				array("title" => "Clasificacion", "fields" => array(
						array("label" => "Clasificacion", "type" => "select", "idName" => "clasificacion", "options" => $arrayClasificaciones),
				)),
     					
     			array("title" => "Ingredientes", "fields" => array(
     					array("label" => "Ingredientes", "type" => "select", "idName" => "ingredientes", "options" => $arrayIngredientes),
     			)),
				
				array("title" => "Condimentos", "fields" => array(
						array("label" => "Condimentos", "type" => "select", "idName" => "condimentos", "options" => $arrayCondimentos),
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
    	$ingredientes = $request->request->get("ingredientes");
    	$condimentos = $request->request->get("condimentos");
    	 
    	$em->beginTransaction();
    	 
    	try{

            if(!empty($nombre))
                $receta->setNombre($nombre);

    		if(!empty($dificultad))
    			$receta->setDificultad($this->getDoctrine()->getRepository("AppBundle:Dificultad")->find($dificultad));

    		if(!empty($temporada))
    			$receta->setTemporada($this->getDoctrine()->getRepository("AppBundle:Temporada")->find($temporada));

     		if(!empty($ingredientes))
     			foreach($ingredientes as $ingrediente)
     				$receta->addIdingrediente($this->getDoctrine()->getRepository("AppBundle:ingrediente")->find($ingrediente));

            if(!empty($condimentos))
                foreach($condimentos as $condimento)
                    $receta->addIdcondimento($this->getDoctrine()->getRepository("AppBundle:Condimento")->find($condimento));


            $receta->setPaso1("ASDASD");
            $receta->setCalificacion(3);


            $user->addIdreceta($receta);
            $receta->addIdusuario($user);

            $em->persist($receta);
            $em->flush();

    	}catch(\Exception $e){
    		$em->rollback();
    		throw($e);
    	}
    	 
    	$em->commit();
    	 
    	return new Response($this->generateUrl("seleccionarRecetas"));
    }


    /**
     * @Route("/agregarAPerfil", name="agregarAPerfil")
     */
    public function agregarAPerfil(Request $request){

        $em = $this->getDoctrine()->getManager();

        $idReceta = $request->request->get('id');
        $dni = $this->getUser();

        $receta = $this->getDoctrine()->getRepository("AppBundle:Receta")->find($idReceta);
        $user = $this->getDoctrine()->getRepository("AppBundle:Usuario")->find($dni);

        $historial = new Historial($user, $receta);
        $historial->setAceptada(1);

        $em->persist($historial);
        $em->flush();

        return new Response("");

    }

}
