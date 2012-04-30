<?php
/* ***************************************************************************
 * AppBundle/Controller/MaestrosController
 * Controlador para gestionar los Maestros
 * (C) Copyright 2012 Ricardo MontaÃ±ana <rmontanana@gmail.com>
 * This file is part of Evaluacion.
 * ***************************************************************************
 * Evaluacion is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Evaluacion is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Evaluacion (LICENSE file). 
 * If not, see <http://www.gnu.org/licenses/>
 * ***************************************************************************
 */

namespace Evaluacion\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Event\DataEvent;
use Symfony\Component\HttpFoundation\Response;
use Evaluacion\AppBundle\Util\Util;
use Evaluacion\AppBundle\Entity\Profesor;


/**
 * @Route("/prof") 
 */
class MaestrosController extends Controller
{
     /**
     * Vamos a hacer un listado de los profesores
     * @Route("/list", name="list_prof")
     * @return string 
     */
    public function AsignacionAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $menu = Util::getMenu();
        $usuario = "Ricardo MontaÃ±ana GÃ³mez"; $enlace="(salir)";
        $centro="I.E.S.O. Pascual Serrano";
        $form = $this->creaFormulario();
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            $datos = $form->getData();

            $datos['Profesor'] = explode('=>', $datos['Profesor']);

            $param = array('titulo' => 'AsignaciÃ³n', 'menu' => $menu,'usuario' => $usuario, 'enlaceUsuario' => $enlace, 'centro' =>$centro,
                       'datos' => $datos, 'unidades' => $unidades);
        }
        return $this->render('AppBundle:Evaluacion:Profesor.html.twig', $param);
    }
}

