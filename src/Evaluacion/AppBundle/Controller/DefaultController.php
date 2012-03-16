<?php

namespace Evaluacion\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Evaluacion\AppBundle\Util\Util;


class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $menu = Util::getMenu();
        return $this->render('AppBundle:Default:index.html.twig', array('name' => $name, 'menu' => $menu));
    }
}
