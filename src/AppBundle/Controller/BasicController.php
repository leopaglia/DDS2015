<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;

class BasicController extends Controller{
	
	protected function renderBasicForm($fieldsets, $buttons, $config, $title){

		return $this->render('Basic/basicForm.html.twig', array("fieldsets" => $fieldsets, "buttons" => $buttons, "config" => $config, "title" => $title));
	}
	
	
}