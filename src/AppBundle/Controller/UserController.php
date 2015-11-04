<?php

namespace AppBundle\Controller;

use AppBundle\Constants\SexosConstants;
use Proxies\__CG__\AppBundle\Entity\Grupo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\CondicionesDeSalud;
use AppBundle\Entity\Rutina;

use AppBundle\Repository\GenericRepository as GenericRepository;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

class UserController extends BasicController{


    /**
     * @Route("/misRecetas", name="myRecipes")
     */
    public function mostrarRecetasAction(){

        $data['title'] = "Mis recetas";

        return $this->render("default/misRecetas.html.twig", $data);
    }

    /**
     * @Route("/misGrupos", name="myGroups")
     */
    public function mostrarGruposAction(){

        $id = $this->getUser();
        $user = $this->getDoctrine()->getRepository('AppBundle:Usuario')->find($id);

        // usuarios para crear grupo
        $data['usuarios'] = $this->getDoctrine()->getRepository("AppBundle:Usuario")->findAll();

        //saca al user logueado
        if(($key = array_search($id, $data['usuarios'])) !== false) {
            unset($data['usuarios'][$key]);
        }

        $grupos = $user->getIdgrupo()->getValues();

        $arrayGrupos = [];
        foreach ($grupos as $grupo){
            $nombre = $grupo->getNombre();
            $users = $grupo->getIdusuario()->getValues();

            $aux = [];
            $aux['nombre'] = $nombre;
            $aux['users'] = $users;

            $arrayGrupos[] = $aux;
        }

        $data['title'] = "Mis grupos";
        $data['grupos'] = $arrayGrupos;

        return $this->render("default/grupos.html.twig", $data);
    }
	
	/**
     * @Route("/modificarPerfil", name="modifyProfile")
     */
    public function modifyProfileAction(){
    	
    	//Datos

        //Generales

        $complexiones = $this->getDoctrine()->getRepository("AppBundle:Complexion")->findAll();
        $condiciones = $this->getDoctrine()->getRepository("AppBundle:CondicionesDeSalud")->findAll();
        $rutinas = $this->getDoctrine()->getRepository("AppBundle:Rutina")->findAll();
        $dietas = $this->getDoctrine()->getRepository("AppBundle:Dieta")->findAll();
        $gruposAlimenticios = $this->getDoctrine()->getRepository("AppBundle:GruposAlimenticios")->findAll();

        $arrayComplexiones = array();
        $arrayCondiciones = array();
        $arrayRutinas = array();
        $arrayDietas = array();
        $arrayGruposAlimenticios = array();

        $arraySexos = array();
        $arraySexos[] = array("name" => 'Masculino', "value" => SexosConstants::MASCULIMO);
        $arraySexos[] = array("name" => 'Femenino', "value" => SexosConstants::FEMENINO);

        foreach ($complexiones as $c){
            $arrayComplexiones[] = array("name" => $c->getNombre(), "value" => $c->getId());
        }
        foreach ($condiciones as $c){
            $arrayCondiciones[] = array("name" => $c->getNombre(), "value" => $c->getId(), "checked" => false);
        }
        foreach ($rutinas as $r){
            $arrayRutinas[] = array("name" => $r->getNombre(), "value" => $r->getId());
        }
        foreach ($dietas as $d){
            $arrayDietas[] = array("name" => $d->getNombre(), "value" => $d->getId());
        }
        foreach ($gruposAlimenticios as $g){
            $arrayGruposAlimenticios[] = array("name" => $g->getNombre(), "value" => $g->getId(), "checked" => false);
        }

        //Usuario

        $id = $this->getUser();
        $user = $this->getDoctrine()->getRepository("AppBundle:Usuario")->find($id);

        //Datos del usuario (Para campo checked de los checklist)

        $condicionesPresentes = $user->getIdcondiciones()->getValues(); //array de objetos CondicionesDeSalud

        foreach($condiciones as $cnd){

            if(in_array($cnd, $condicionesPresentes)){ //busco la condicion y pongo en true el campo checked en el array que voy a mandar al html

                $index = array_search(array("name" => $cnd->getNombre(), "value" => $cnd->getId(), "checked" => false), $arrayCondiciones);

                if($index !== false) $arrayCondiciones[$index]["checked"] = true;

            }

        }

        $grupos = $user->getIdGrupoalim()->getValues(); //array de objetos CondicionesDeSalud

        foreach($grupos as $gr){

            if(in_array($gr, $grupos)){ //busco la condicion y pongo en true el campo checked en el array que voy a mandar al html

                $index = array_search(array("name" => $gr->getNombre(), "value" => $gr->getId(), "checked" => false), $arrayGruposAlimenticios);

                if($index !== false) $arrayGruposAlimenticios[$index]["checked"] = true;

            }

        }

        //para que seleccione si hay datos cargados

        $nombre = '';
        $apellido = '';
        $edad = '';
        $sexo = '';
        $altura = '';
        $rutina_id = '';
        $complexion_id  = '';
        $dieta_id = '';

        if ($user->getNombre())
            $nombre = $user->getNombre();

        if ($user->getApellido())
            $apellido = $user->getApellido();

        if ($user->getEdad())
            $edad = $user->getEdad();

        if ($user->getSexo())
            $sexo = $user->getSexo();

        if ($user->getAltura())
            $altura = $user->getAltura();

        if ($user->getRutina())
            $rutina_id = $user->getRutina()->getId();

        if ($user->getComplexion())
            $complexion_id = $user->getComplexion()->getId();

        if ($user->getDieta())
            $dieta_id = $user->getDieta()->getId();


     	//Vista

     	$fieldsets = array(
     		
     			array("title" => "Detalle de Usuario", "fields" => array(
     					array("label" => "Nombre", "type" => "input", "idName" => "nombre", "placeholder" => "Ingrese su Nombre", "value" => $nombre),
     					array("label" => "Apellido", "type" => "input", "idName" => "apellido", "placeholder" => "Ingrese su Apellido", "value" => $apellido),
     					array("label" => "Edad", "type" => "input", "idName" => "edad", "placeholder" => "Ingrese su Edad", "value" => $edad),
                        array("label" => "Sexo", "type" => "select", "idName" => "sexo", "options" => $arraySexos, "value" => $sexo),
     					array("label" => "Altura", "type" => "input", "idName" => "altura", "placeholder" => "Ingrese su Altura (en centimetros)", "value" => $altura),
                        array("label" => "Complexion", "type" => "select", "idName" => "complexion", "options" => $arrayComplexiones, "value" => $complexion_id),
     			)),

                array("title" => "Dieta y Rutina", "fields" => array(
                    array("label" => "Rutina", "type" => "select", "idName" => "rutina", "options" => $arrayRutinas, "value" => $rutina_id),
                    array("label" => "Dieta", "type" => "select", "idName" => "dieta", "options" => $arrayDietas, "value" => $dieta_id)
                )),

                array("title" => "Grupos Alimenticios", "fields" => array(
                    array("label" => "Grupos Alimenticios", "type" => "checklist", "idName" => "gruposAlimenticios", "options" => $arrayGruposAlimenticios),
                )),

     			array("title" => "Condiciones Preexistentes", "fields" => array(
     					array("label" => "Condiciones preexistentes", "type" => "checklist", "idName" => "condiciones", "options" => $arrayCondiciones),
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

    	$em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
    	
    	$id = $this->getUser();
    	$user = $this->getDoctrine()->getRepository("AppBundle:Usuario")->find($id);

        $allCondiciones = $this->getDoctrine()->getRepository("AppBundle:CondicionesDeSalud")->findAll();
        $allGruposAlim = $this->getDoctrine()->getRepository("AppBundle:GruposAlimenticios")->findAll();
    	
    	$nombre = $request->request->get("nombre");
    	$apellido = $request->request->get("apellido");
    	$edad = $request->request->get("edad");
    	$altura = $request->request->get("altura");
        $sexo = $request->request->get("sexo");
    	$rutina = $request->request->get("rutina");
        $dieta = $request->request->get("dieta");
    	$complexion = $request->request->get("complexion");
    	$condiciones = $request->request->get("condiciones");
        $gruposAlimenticios = $request->request->get("gruposAlimenticios");

        $em->beginTransaction();
    	
    	try{

            $user->setUltimaActualizacion(new \DateTime('now'));
    		
    		if(!empty($nombre))
    			$user->setNombre($nombre);
    		if(!empty($apellido))
	    		$user->setApellido($apellido);
    		if(!empty($edad))
	    		$user->setEdad($edad);
    		if(!empty($altura))
	    		$user->setAltura($altura);
            if(!empty($sexo))
                $user->setSexo($sexo);
    		if(!empty($rutina))
	    		$user->setRutina($this->getDoctrine()->getRepository("AppBundle:Rutina")->find($rutina));
            if(!empty($dieta))
                $user->setDieta($this->getDoctrine()->getRepository("AppBundle:Dieta")->find($dieta));
    		if(!empty($complexion))
	    		$user->setComplexion($this->getDoctrine()->getRepository("AppBundle:Complexion")->find($complexion));

            //borro todas las condiciones
            foreach($allCondiciones as $c){
                if ($user->getIdcondiciones()->contains($c) ) {
                    $user->removeIdcondicione($c);
                    $c->removeIdusuario($user);
                }
            }
            //agrego las que vienen del form
    		if(!empty($condiciones)){
                foreach($condiciones as $condicionId){

                    $condicion = $this->getDoctrine()->getRepository("AppBundle:CondicionesDeSalud")->find($condicionId);
                    $user->addIdcondicione($condicion);
                    $condicion->addIdusuario($user);

                }
            }

            //borro todas los grupos
            foreach($allGruposAlim as $g){
                if ($user->getIdGrupoalim()->contains($g) ) {
                    $user->removeIdGrupoalim($g);
                    $g->removeDni($user);
                }
            }
            //agrego lps que vienen del form
            if(!empty($gruposAlimenticios)){
                foreach($gruposAlimenticios as $grupoId){

                    $grupo = $this->getDoctrine()->getRepository("AppBundle:GruposAlimenticios")->find($grupoId);
                    $user->addIdGrupoalim($grupo);
                    $grupo->addDni($user);

                }
            }

	    	$em->persist($user);
	    	$em->flush();
    			
    	}catch(\Exception $e){
    		$em->rollback();

            //$session->getFlashBag()->add('error', "[DEGUG] ".$e->getMessage());
        }
    	
    	$em->commit();

        $session->getFlashBag()->add('notice', "Perfil actualizado exitosamente");

    	return new Response($this->generateUrl("modifyProfile"));
    	
    }

    /**
     * @Route("/crearGrupo", name="createGroup")
     */
    public function crearGrupoAction(Request $request){

        $userRepo = $this->getDoctrine()->getRepository('AppBundle:Usuario');
        $em = $this->getDoctrine()->getManager();

        $id = $this->getUser();

        $idArray = $request->request->get("usuarios");
        $idArray[] = $id; //agrega al user logueado

        $nombreGrupo = $request->request->get("nombreGrupo");

        $grupo = new Grupo();
        $grupo->setNombre($nombreGrupo);

        foreach ($idArray as $id){
            $user = $userRepo->find($id);
            $grupo->addIdusuario($user);
            $user->addIdgrupo($grupo);
        };

        $em->persist($grupo);
        $em->flush();

    	return new JsonResponse("");
    }

}
