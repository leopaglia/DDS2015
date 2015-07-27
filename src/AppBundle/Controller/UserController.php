<?php

namespace AppBundle\Controller;

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

class UserController extends BasicController{

	/**
	 * @Route("/perfil", name="profile")
	 */
	public function profileAction(){
		return $this->render("default/perfil.html.twig");	
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

            //Usuario

            $dni = $this->getUser();
            $user = $this->getDoctrine()->getRepository("AppBundle:Usuario")->find($dni);


     	//Vista
     	
     	$fieldsets = array(
     		
     			array("title" => "Detalle de Usuario", "fields" => array(
     					array("label" => "Nombre", "type" => "input", "idName" => "nombre", "placeholder" => "Ingrese su Nombre", "value" => $user->getNombre()),
     					array("label" => "Apellido", "type" => "input", "idName" => "apellido", "placeholder" => "Ingrese su Apellido", "value" => $user->getApellido()),
     					array("label" => "Edad", "type" => "input", "idName" => "edad", "placeholder" => "Ingrese su Edad", "value" => $user->getEdad()),
     					array("label" => "Altura", "type" => "input", "idName" => "altura", "placeholder" => "Ingrese su Altura (en centimetros)", "value" => $user->getAltura()),
     					array("label" => "Rutina", "type" => "select", "idName" => "rutina", "options" => $arrayRutinas, "value" => $user->getRutina()->getId())
     			)),
     					
     			array("title" => "Complexion", "fields" => array(
     					array("label" => "Complexion", "type" => "select", "idName" => "complexion", "options" => $arrayComplexiones, "value" => $user->getComplexion()->getId()),
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

    	$em = $this->getDoctrine()->getManager();
    	
    	$dni = $this->getUser();
    	$user = $this->getDoctrine()->getRepository("AppBundle:Usuario")->find($dni);
    	
    	$nombre = $request->request->get("nombre");
    	$apellido = $request->request->get("apellido");
    	$edad = $request->request->get("edad");
    	$altura = $request->request->get("altura");
    	$rutina = $request->request->get("rutina");
    	$complexion = $request->request->get("complexion");
    	$condiciones = $request->request->get("condiciones"); 
    	
    	$em->beginTransaction();
    	
    	try{
    		
    		if(!empty($nombre))
    			$user->setNombre($nombre);
    		if(!empty($apellido))
	    		$user->setApellido($apellido);
    		if(!empty($edad))
	    		$user->setEdad($edad);
    		if(!empty($altura))
	    		$user->setAltura($altura);
    		if(!empty($rutina))
	    		$user->setRutina($this->getDoctrine()->getRepository("AppBundle:Rutina")->find($rutina));
    		if(!empty($complexion))
	    		$user->setComplexion($this->getDoctrine()->getRepository("AppBundle:Complexion")->find($complexion));
    		if(!empty($condiciones))
	    		foreach($condiciones as $condicion)
		    		$user->addCondicion($this->getDoctrine()->getRepository("AppBundle:CondicionesDeSalud")->find($condicion[0])); //FIXME?? capaz no //TESTME lel
		    	
	    	$em->persist($user);
	    	$em->flush();
    			
    	}catch(\Exception $e){
    		$em->rollback();

            $session = $this->getRequest()->getSession();
            $session->getFlashBag()->add('error', "[DEGUG]".$e->getMessage());

        }
    	
    	$em->commit();
    	
    	return new Response($this->generateUrl("modifyProfile")); //Reload to
    	
    }
    
    /**
     * @Route("/buscarUsuario", name="findUser")
     */
    public function buscarUsuarioAction(Request $request){
    	
    	$nombre = $request->get("nombre");
    	
    	$qb = $this->getDoctrine()->getEntityManager()->createQueryBuilder();

		$qb->select("u")
			->from("AppBundle:Usuario", "u");
    	
		if(!empty ($nombre) && trim($nombre != "")){
			$nombre = trim($nombre);
			$qb->andWhere($qb->expr()->andx($qb->expr()->like('u.username', ':nombre')));
			$qb->setParameter(':nombre', '%'.$nombre.'%');
		}
		
		$usuario = $qb->getQuery()->getFirstResult();

        $arrayUsuario = array();

		$arrayUsuario["id"] = $usuario->getId();
		$arrayUsuario["nombre"] = $usuario->getUsername();
		
			
    	return new JsonResponse($arrayUsuario);
    }

    /**
     * @Route("/crearGrupo", name="createGroup")
     */
    public function crearGrupoAction(){
    	//return $this->render("default/perfil.html.twig");
    }

}
