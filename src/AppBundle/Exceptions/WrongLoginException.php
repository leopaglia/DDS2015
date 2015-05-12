<?php
namespace AppBundle\Exceptions;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class WrongLoginException extends CustomException{
    public $code = 401;
    public $redirect_path = 'login';
    public $message = "Usuario o contraseña incorrectos.";
}