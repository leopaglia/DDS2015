<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;

use AppBundle\Entity\Usuario;
use AppBundle\Entity\Receta;
use AppBundle\Entity\Historial;
use AppBundle\Entity\IngredienteReceta;

use AppBundle\Constants\ConfigConstants;

class RecetasController extends BasicController{

    // ------------ RENDERS ------------

	/**
     * @Route("/seleccionarRecetas", name="seleccionarRecetas")
     */
    public function seleccionarRecetasAction(){

        $data = array();
        $data['url'] = array();

        $data['temporadas'] = $this->getDoctrine()->getRepository("AppBundle:Temporada")->findAll();
        $data['dificultades'] = $this->getDoctrine()->getRepository("AppBundle:Dificultad")->findAll();
        $data['clasificaciones'] = $this->getDoctrine()->getRepository("AppBundle:Clasificacion")->findAll();
        $data['gruposAlimenticios'] = $this->getDoctrine()->getRepository("AppBundle:GruposAlimenticios")->findAll();
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
     * @Route("/cargarReceta", name="generateRecipe")
     */
    public function generarRecetaAction(){

        $data = [];
        $data["title"] = "Cargar nueva receta";
        $data['action'] = $this->generateUrl('saveRecipe');

        $data['dificultades'] = $this->getDoctrine()->getRepository("AppBundle:Dificultad")->findAll();
        $data['temporadas'] = $this->getDoctrine()->getRepository("AppBundle:Temporada")->findAll();
        $data['gruposAlimenticios'] = $this->getDoctrine()->getRepository("AppBundle:GruposAlimenticios")->findAll();
        $data['ingredientes'] = $this->getDoctrine()->getRepository("AppBundle:Ingrediente")->findAll();
        $data['condimentos'] = $this->getDoctrine()->getRepository("AppBundle:Condimento")->findAll();
        $data['clasificaciones'] = $this->getDoctrine()->getRepository("AppBundle:Clasificacion")->findAll();


        return $this->render("default/nuevaReceta.html.twig", $data);
    }

    /**
     * @Route("/verReceta/{id}", name="verReceta")
     */
    public function verRecetaAction($id){

        $em = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('AppBundle:Usuario')->find($this->getUser());
        $receta = $this->getDoctrine()->getRepository('AppBundle:Receta')->find($id);

        $ingredientes = $receta->getIdingrediente()->getValues();
        $condimentos = $receta->getIdcondimento()->getValues();

        $arrayReceta = array();

        $arrayReceta["id"] = $receta->getId();
        $arrayReceta["nombre"] = $receta->getNombre();
        $arrayReceta["temporada"] = $receta->getTemporada()->getNombre();
        $arrayReceta["dificultad"] = $receta->getDificultad()->getDescripcion();
        $arrayReceta["calorias"] = $this->calcularCalorias($receta);
        $arrayReceta["calificacion"] = $receta->getCalificacion();
        $arrayReceta["owner"] = $receta->getIdUsuario();
        $arrayReceta["ingredientes"] = array();
        $arrayReceta["condimentos"] = array();

        foreach ($ingredientes as $i) {
            $intermedia = $this->getDoctrine()->getRepository("AppBundle:IngredienteReceta")->findOneBy(array("idreceta" => $receta, "idingrediente" => $ingredientes));
            $cantidad = $intermedia->getCantidad();
            $arrayReceta["ingredientes"][] = array("nombre" => $i->getNombre(), "cantidad" => $cantidad, "unidad" => $i->getUnidad());
        }

        foreach ($condimentos as $c) {
            $arrayReceta["condimentos"][] = $c->getNombre();
        }

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

        $historial = new Historial($user, $receta, 0);

        $em->persist($historial);
        $em->flush();

        return $this->render("default/receta.html.twig", $arrayReceta);
    }


    // ------------ ACTIONS ------------


    /**
     * @Route("/buscarRecetas", name="buscarRecetas")
     */
    public function buscarRecetasAction(Request $request){

        $id = $this->getUser();
        $user = $this->getDoctrine()->getRepository("AppBundle:Usuario")->find($id);

        $filtros = array();

        $filtros['nombre'] = $request->request->get('nombre');
        $filtros['temporada'] = $request->request->get('temporada');
        $filtros['dificultad'] = $request->request->get('dificultad');
        $filtros['clasificacion'] = $request->request->get('clasificacion');
        $filtros['grupoAlimenticio'] = $request->request->get('grupoAlimenticio');
        $filtros['owner'] = $request->request->get('owner');

        $caloriasDesde = $request->request->get('caloriasDesde');
        $caloriasHasta = $request->request->get('caloriasHasta');

        $acceptVisitors = true;
        if ($filtros['owner'] == 'me') $acceptVisitors = false; //si busco mis recetas, que no las filtre

    	$recetas = $this->getDoctrine()->getRepository('AppBundle:Receta')->getRecetasByFilters($filtros, $user, $acceptVisitors);

        // saco las recetas que no son mias, de mis grupos o del sistema
        $recetas = $this->sacarRecetasExternas($recetas);
    	
		$arrayRecetas = array();

        if (!empty($recetas)) {

            foreach($recetas as $receta){

                if( ! ($this->caloriasEnRango($receta, $caloriasDesde, $caloriasHasta)) )
                    continue;

                $arrayReceta = array();

                $url = $this->generateUrl('verReceta', array('id' => $receta->getId()));

                $arrayReceta["id"] = $receta->getId();
                $arrayReceta["nombre"] = '<a href="'.$url.'">'.$receta->getNombre().'</a>';
                $arrayReceta["temporada"] = $receta->getTemporada()->getNombre();
                $arrayReceta["dificultad"] = $receta->getDificultad()->getDescripcion();
                $arrayReceta["calorias"] = $this->calcularCalorias($receta);
                $arrayReceta["calificacion"] = $receta->getCalificacion();
                $arrayReceta["check"] = $this->shouldCheck($receta);

                $arrayRecetas[] = $arrayReceta;
            }

        }
    	
    	return new JsonResponse($arrayRecetas);
    }

    /**
     * @Route("/generarReporte", name="generarReporte")
     */
    public function generarReporteAction(Request $request){

        $id = $this->getUser();
        $user = $this->getDoctrine()->getRepository("AppBundle:Usuario")->find($id);

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
                $arrayReceta["calorias"] = $this->calcularCalorias($receta);
                $arrayReceta["calificacion"] = $receta->getCalificacion();

                $arrayRecetas[] = $arrayReceta;
            }

        }

        return new JsonResponse($arrayRecetas);
    }

    
    /**
     * @Route("/guardarReceta", name="saveRecipe")
     */
    public function guardarRecetaAction(Request $request){
    	
    	$em = $this->getDoctrine()->getManager();
    	 
    	$idUsuario = $this->getUser();
    	$user = $this->getDoctrine()->getRepository("AppBundle:Usuario")->find($idUsuario);
    	
    	$nombre = $request->request->get("nombre");
    	$dificultad = $request->request->get("dificultad");
    	$temporada = $request->request->get("temporada");
    	$ingredientes = $request->request->get("ingredientes");
    	$grupoAlimenticio = $request->request->get("grupoAlimenticio");
        $clasificaciones = $request->request->get("clasificaciones");
        $condimentos = $request->request->get("condimentos");

        $foto1 = $request->request->get("foto1");
        $foto2 = $request->request->get("foto2");
        $foto3 = $request->request->get("foto3");
        $foto4 = $request->request->get("foto4");
        $foto5 = $request->request->get("foto5");

        $paso1 = $request->request->get("paso1");
        $paso2 = $request->request->get("paso2");
        $paso3 = $request->request->get("paso3");
        $paso4 = $request->request->get("paso4");
        $paso5 = $request->request->get("paso5");

        $receta = new Receta();

    	$em->beginTransaction();
    	 
    	try{

            $receta->setPaso1("default"); //not null

            // flushing to generate id
            $em->persist($receta);
            $em->flush();

            if(!empty($nombre))
                $receta->setNombre($nombre);

    		if(!empty($dificultad))
    			$receta->setDificultad($this->getDoctrine()->getRepository("AppBundle:Dificultad")->find($dificultad));

    		if(!empty($temporada))
    			$receta->setTemporada($this->getDoctrine()->getRepository("AppBundle:Temporada")->find($temporada));

     		if(!empty($ingredientes))
     			foreach($ingredientes as $ing){
                    $ingrediente = $this->getDoctrine()->getRepository("AppBundle:Ingrediente")->find($ing['id']);

                    $ingrediente_receta = new IngredienteReceta();
                    $ingrediente_receta->setIngrediente($ingrediente);
                    $ingrediente_receta->setReceta($receta);
                    $ingrediente_receta->setcantidad($ing['cant']);

                    $em->persist($ingrediente_receta);

                }

            if(!empty($condimentos))
                foreach($condimentos as $condimento_id){
                    $condimento = $this->getDoctrine()->getRepository("AppBundle:Condimento")->find($condimento_id);
                    $receta->addIdcondimento($condimento);
                    $condimento->addIdrecetum($receta);
                }

            if(!empty($clasificaciones))
                foreach($clasificaciones as $clasificacion_id){
                    $clasificacion = $this->getDoctrine()->getRepository("AppBundle:Clasificacion")->find($clasificacion_id);
                    $receta->addIdClasificacion($clasificacion);
                    $clasificacion->addIdrecetum($receta);
                }


            if(!empty($grupoAlimenticio))
                $receta->setGrupoAlim($this->getDoctrine()->getRepository("AppBundle:GruposAlimenticios")->find($grupoAlimenticio));

            $receta->setIdUsuario($user);

            $receta->setPaso1($paso1);
            $receta->setPaso2($paso2);
            $receta->setPaso3($paso3);
            $receta->setPaso4($paso4);
            $receta->setPaso5($paso5);

            $receta->setFoto1($foto1);
            $receta->setFoto2($foto2);
            $receta->setFoto3($foto3);
            $receta->setFoto4($foto4);
            $receta->setFoto5($foto5);

            $receta->setCalificacion(3);

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

        $historial = new Historial($user, $receta, 1);

        $em->persist($historial);
        $em->flush();

        return new Response("");

    }

    /**
     * @Route("/eliminarReceta", name="eliminarReceta")
     */
    public function eliminarRecetaAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $id = $request->request->get('id');
        $receta = $this->getDoctrine()->getRepository("AppBundle:Receta")->find($id);

        $clasificaciones = $receta->getIdClasificacion();
        $condimentos = $receta->getIdcondimento();
        $ingredientes = $receta->getIdingrediente();

        $historiales = $this->getDoctrine()->getRepository("AppBundle:Historial")->findByIdreceta($id);

        foreach ($clasificaciones as $c){
            $c->removeIdRecetum($receta);
            $receta->removeIdClasificacion($c);
        }

        foreach ($condimentos as $c) {
            $c->removeIdRecetum($receta);
            $receta->removeIdcondimento($c);
        }

        foreach ($ingredientes as $i) {
            $i->removeIdRecetum($receta);
            $receta->removeIdingrediente($i);
        }

        foreach ($historiales as $h){
            $em->remove($h);
        }

        $em->persist($receta);
        $em->flush();

        $em->remove($receta);
        $em->flush();

        return new Response("");

    }

    /**
     * @Route("/calificarReceta", name="calificarReceta")
     */
    public function calificarRecetaAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $id_receta = $request->request->get('id');
        $puntaje = $request->request->get('puntaje');

        $receta = $this->getDoctrine()->getRepository("AppBundle:Receta")->find($id_receta);

        $calif_vieja = $receta->getCalificacion();
        $calif_nueva = ($calif_vieja + $puntaje) / 2;

        $receta->setCalificacion(ceil($calif_nueva));

        $historial = new Historial($this->getUser(), $receta, 2);

        $em->persist($receta);
        $em->persist($historial);
        $em->flush();

        return new Response("");

    }

        // ------------------ PRIVATE --------------------

    private function calcularCalorias(Receta $receta) {

        $ingredientes = $receta->getIdingrediente()->toArray();

        $ac = 0;
        foreach($ingredientes as $i) {

            $ing_rec = $this->getDoctrine()->getRepository("AppBundle:IngredienteReceta")->findOneBy(array("idreceta" => $receta, "idingrediente" => $i));
            $cantidad = $ing_rec->getcantidad();

            $cantidad_porcion = $i->getPorcion();
            $caloriasPorcion = $i->getCaloriasPorcion();

            $ac += ($cantidad/$cantidad_porcion) * $caloriasPorcion;

        }

        return $ac;
    }

    private function caloriasEnRango(Receta $receta, $caloriasDesde, $caloriasHasta) {

        if (empty($caloriasDesde) && empty($caloriasHasta))
            return true;

        if(empty($caloriasDesde))
            return ($this->calcularCalorias($receta) < $caloriasHasta);

        if(empty($caloriasHasta))
            return ($this->calcularCalorias($receta) > $caloriasDesde);

        return ($this->calcularCalorias($receta) > $caloriasDesde) && ($this->calcularCalorias($receta) < $caloriasHasta);
    }

    private function sacarRecetasExternas($recetas) {

        $idUsuario = $this->getUser();
        $user = $this->getDoctrine()->getRepository("AppBundle:Usuario")->find($idUsuario);

        $grupos = $user->getIdgrupo()->getValues();

        $usersIdDeMisGrupos = array();
        $usersIdDeMisGrupos[] = ConfigConstants::SISTEMA_ID;

        foreach ($grupos as $g){

            $users = $g->getIdusuario()->getValues();

            foreach ($users as $u)
                if ( ! in_array($u->getId(), $usersIdDeMisGrupos) ) $usersIdDeMisGrupos[] = $u->getId();

        }

        $i = 0;
        foreach ($recetas as $r){

            if ( ! in_array($r->getIdUsuario()->getId(), $usersIdDeMisGrupos) )
                unset($recetas[$i]);

            $i++;
        }

        return $recetas;

    }

    private function shouldCheck(Receta $receta){

        //si es del user logueado
        if ($receta->getIdUsuario() == $this->getUser())
            return true;

        $aceptada = $this->getDoctrine()->getRepository("AppBundle:Historial")->findBy(
            array(
                "idusuario" => $this->getUser(),
                "idreceta" => $receta->getId(),
                "aceptada" => 1
            )
        );

        // si ya fue aceptada
        if(!empty($aceptada))
            return true;

        return false;


    }

}
