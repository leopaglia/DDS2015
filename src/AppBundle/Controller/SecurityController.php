<?php

namespace AppBundle\Controller;

use AppBundle\Exceptions\WrongLoginException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session;

use AppBundle\Entity\Usuario;

class SecurityController extends Controller
{

	/**
     * @Route("/login", name="login")
     */
    public function loginAction(){
    	
	 	$authenticationUtils = $this->get('security.authentication_utils');
	
	    // get the login error if there is one
	    $error = $authenticationUtils->getLastAuthenticationError();
	
	    // last username entered by the user
	    $lastUsername = $authenticationUtils->getLastUsername();
	
	    return $this->render('security/login.html.twig', array('last_username' => $lastUsername, 'error' => $error,  "title" => "DDS 2015"));
    }
    
    /**
     * @Route("/signup", name="signup")
     */
    public function signupAction(Request $request){
    	 
    	$dni =  $request->request->get("_dni");
    	$user = $request->request->get("_username");
    	$pass = $request->request->get("_password");
    	$sexo = $request->request->get("_sexo");
    	$edad = $request->request->get("_edad");
    	
    	$newUser = new Usuario($dni, $user, $pass, $sexo, $edad);
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($newUser);
    	$em->flush();
    	
    	$session = $request->getSession();
    	$session->getFlashBag()->add('notice', 'Usuario creado con exito.');
    	
    	return $this->loginAction();
    	//return $this->render('security/login.html.twig', array('last_username' => $user, 'error' => "Usuario creado correctamente.",  "title" => "DDS 2015"));
    
    }
    
    public function onAuthenticationFailure(AuthenticationFailureEvent $exception){
    	
    	//return new RedirectResponse($this->generateUrl('login'));
		throw new WrongLoginException("Usuario o contraseña incorrectos."); //una verga, cambiar esto
    }	
    	
    // these controllers will not be executed,
    // as the route is handled by the Security system
    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction(){}
    
    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction(){}
}
