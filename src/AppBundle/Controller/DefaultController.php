<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;


class DefaultController extends Controller
{
    /**
	 * @Security("has_role('ROLE_USER')")
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
//     	$session = $this->getRequest()->getSession();
//     	$session->set("ID_USER", $this->getUser()->getDni());
//     	$session->getFlashBag()->add('error', 'Profile updated');
    	
        return $this->render('default/index.html.twig');
    }    
}
