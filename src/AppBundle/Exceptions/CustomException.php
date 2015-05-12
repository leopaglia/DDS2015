<?php
namespace AppBundle\Exceptions;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\Routing;

class CustomException extends \Exception{
	
    //-----Deben ser overrideados en cada excepcion-----
    public $code;
    public $redirect_path;
    //--------------------------------------------------
    
    public function __construct($msj = ''){
        $this->message = $msj;
    }
    
    public function getStatusCode(){
        return $this->code;
    }
    
    public function getResponse(GetResponseForExceptionEvent $event){
        $msj = $this->getMessage();
        
        if ($this->code != "")
            $msj = '(' . $this->code . ') ' . $this->getMessage();
        
        $event->getRequest()->getSession()->getFlashBag()->add('msjError', $msj);
        $red = new RedirectResponse('\\' . $this->redirect_path);
        $event->setResponse($red);
        
        return;
    }
    
}