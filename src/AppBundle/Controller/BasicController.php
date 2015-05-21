<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;

use AppBundle\Entity\Usuario;

class BasicController extends Controller{
	
	//TODO extender para checklists (condiciones)
	
	protected function renderBasicForm($fields, $buttons, $options, $title){
		
		return $this->render('Basic/basicForm.html.twig', array("fields" => $fields, "buttons" => $buttons, "options" => $options, "title" => $title));
	}
	
	
}