<?php

namespace Evaluacion\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Evaluacion\AppBundle\Util\Util;


class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $menu = Util::getMenu();
        $usuario = "Ricardo Montañana Gómez"; $enlace = "(salir)";
        $centro = "I.E.S.O. Pascual Serrano";
        $param = array('titulo' => 'Índice', 'name' => $name, 'menu' => $menu,'usuario' => $usuario, 'enlaceUsuario' => $enlace,'centro' =>$centro);
        return $this->render('AppBundle:Default:index.html.twig', $param);
    }
}
