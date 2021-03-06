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

class EstadisticasController extends BasicController{

	/**
     * @Route("/estadisticas", name="estadisticas")
     */
    public function estadisticasAction(){

        $data = array();
        $data['url'] = array();

        $data['dificultades'] = $this->getDoctrine()->getRepository("AppBundle:Dificultad")->findAll();
        $data['url']['agregarAPerfil'] = $this->generateUrl('agregarAPerfil');



        return $this->render('Default/estadisticas.html.twig', array("title" => "Estadisticas", "data" => $data));
    }

    /**
     * @Route("/estadisticasRecetas", name="getEstadisticasRecetas")
     */
    public function estadisticasRecetasAction(Request $request){

        $filtros = array();

        $filtros['rango'] = $request->request->get('rango');
        $filtros['sexo'] = $request->request->get('sexo');
        $filtros['dificultad'] = $request->request->get('dificultad');

        $recetas = $this->getDoctrine()->getRepository('AppBundle:Receta')->getTopRecetas(null, $filtros);

        $arrayRecetas = array();

        if (!empty($recetas)) {

            foreach($recetas as $receta){

                $arrayReceta = array();

                $url = $this->generateUrl('verReceta', array('id' => $receta[0]->getId()));

                $arrayReceta["id"] = $receta[0]->getId();
                $arrayReceta["nombre"] = '<a href="'.$url.'">'.$receta[0]->getNombre().'</a>';
                $arrayReceta["dificultad"] = $receta[0]->getDificultad()->getDescripcion();
                $arrayReceta["visitas"] = $receta["views"];

                $arrayRecetas[] = $arrayReceta;

            }

        }

        return new JsonResponse($arrayRecetas);
    }

}
