<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;

use AppBundle\Entity\Receta;
use AppBundle\Constants;

class DefaultController extends Controller
{
    /**
	 * @Security("has_role('ROLE_USER')")
     * @Route("/", name="homepage")
     */
    public function indexAction(){

        $id = $this->getUser();
        $user = $this->getDoctrine()->getRepository("AppBundle:Usuario")->find($id);

        if(!$user->getUltimaActualizacion()){
            //$session->getFlashBag()->add('notice', "Bienvenido/a al sitio! Completa tu perfil antes de continuar.");
            return $this->redirect($this->generateUrl('modifyProfile'))->sendHeaders();
        }

        $data = array();
        $data['ranking'] = Array();
        $data['recomendados'] = array();

        //data[recomendados]

        $recetas = $this->getDoctrine()->getRepository("AppBundle:Receta")->getRecomendaciones($user);
        foreach($recetas as $receta) {
            $arrayReceta = array();

            $arrayReceta["receta"]["nombre"] = $receta->getNombre();
            $arrayReceta["receta"]["url"] = $this->generateUrl('verReceta', array('id' => $receta->getId()));
            $arrayReceta["dificultad"] = $receta->getDificultad()->getDescripcion();

            $data['recomendados'][] = $arrayReceta;
        }

        //data[ranking]

        $topRecetas = $this->getDoctrine()->getRepository("AppBundle:Receta")->getTopRecetas(10);
        foreach($topRecetas as $receta) {
            $arrayReceta = array();

            $arrayReceta["receta"]["nombre"] = $receta[0]->getNombre();
            $arrayReceta["receta"]["url"] = $this->generateUrl('verReceta', array('id' => $receta[0]->getId()));
            $arrayReceta["visitas"] = $receta["views"];

            $data['ranking'][] = $arrayReceta;
        }


    	return $this->render('default/index.html.twig', array("data" => $data));
    }    
}
