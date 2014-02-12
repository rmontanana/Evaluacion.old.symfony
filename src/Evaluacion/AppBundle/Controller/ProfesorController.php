<?php
/* ***************************************************************************
 * AppBundle/Controller/ProfesorController
 * Controlador para gestionar los Profesores
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
class ProfesorController extends Controller
{
    /**
     * Vamos a hacer un listado de los profesores
     * @Route("/list", name="list_prof")
     * @return string 
     */
<<<<<<< HEAD
    public function MostrarProfesores()
=======
    public function AsignacionAction()
>>>>>>> master
    {
        $em = $this->getDoctrine()->getEntityManager();
        $menu = Util::getMenu();
        $usuario = "Ricardo Montanana Gomez"; $enlace="(salir)";
        $centro = "I.E.S.O. Pascual Serrano";
        $profesores = $em->getRepository('AppBundle:Profesor')->findAll();
<<<<<<< HEAD
        $param = array('titulo' => 'Profesores', 'menu' => $menu, 'usuario' => $usuario, 'enlaceUsuario' => $enlace, 'centro' =>$centro,
=======
        $param = array('titulo' => 'Asignación', 'menu' => $menu,'usuario' => $usuario, 'enlaceUsuario' => $enlace, 'centro' =>$centro,
>>>>>>> master
                       'profesores' => $profesores);
        return $this->render('AppBundle:Maestros:Profesor.html.twig', $param);
    }
    
<<<<<<< HEAD
        /**
     * Vamos a hacer una alta de un profesor
     * @Route("/alta", name="alta_prof")
     * @return string 
     */
    public function AltaProfesor()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $menu = Util::getMenu();
        $usuario = "Ricardo Montanana Gomez"; $enlace="(salir)";
        $centro = "I.E.S.O. Pascual Serrano";
        $profesores = $em->getRepository('AppBundle:Profesor')->findAll();
        $form = $this->creaFormulario();
        $param = array('titulo' => 'AltaProfesores', 'menu' => $menu,'usuario' => $usuario, 'enlaceUsuario' => $enlace, 'centro' =>$centro,
                       'profesores' => $profesores, 'form' => $form->createView() );
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            $datos = $form->getData();
            $profesor = new Profesor();     
            $profesor->setSalt(md5(time() + rand(100, 10000)));
            $encoder = $this->container->get('security.encoder_factory')->getEncoder($profesor);
            $profesor->setNombre($datos['nombre']);
            $profesor->setEmail($datos['email']);
            $profesor->setUsuario($datos['usuario']);
            $profesor->setPassword($encoder->encodePassword($datos['password'], $profesor->getSalt()));
            $profesor->setRol('ROL_USER');
            $em->persist($profesor);
            $em->flush();
            $param = array('titulo' => 'Profesores', 'menu' => $menu,'usuario' => $usuario, 'enlaceUsuario' => $enlace, 'centro' =>$centro,
                       'profesores' => $profesores);
            return $this->render('AppBundle:Maestros:Profesor.html.twig', $param);
        }
        return $this->render('AppBundle:Maestros:AltaProfesor.html.twig', $param);
    }
    
        /**
     * Crea el formulario para añadir un nuevo profesor
     * @return formulario 
     */
    private function creaFormulario()
    {    
        $factory = $this->get('form.factory');
        $builder=$this->createFormBuilder();
        $form = $builder
        ->add('nombre', 'text')
        ->add('email', 'email')
        ->add('usuario', 'text')
        ->add('password', 'repeated', array(
        'type' => 'password',
        'invalid_message' => 'Las dos contraseñas deben coincidir',
        'options' => array('label' => 'Contraseña')))
        ->getForm();
        return $form;
    }
    
    /**
     * Vamos a hacer un listado de los profesores
     * @Route("/modProfesor", name="ajax_editarProfesor")
=======
    /**
     * Vamos a hacer un listado de los profesores
     * @Route("/modNombre", name="ajax_editarProfesor")
>>>>>>> master
     * @return string 
     */
    public function ajaxEditarProfesor()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $valor = $this->getRequest()->get('value');
            $anterior = $this->getRequest()->get('anterior');
            $campo = $this->getRequest()->get('campo');
            // Si no se ha cambiado el valor de la cadena no hace nada
            if ($anterior == $valor) {
                return new Response($valor);
            }
            // Separamos el campo del identificador.
            list($campo, $clave) = explode(".", $this->getRequest()->get('id'));
            $em = $this->getDoctrine()->getEntityManager();
            $profesor = $em->getRepository('AppBundle:Profesor')
                            ->find($clave);
            if ($campo == 'nombre') {
                if ($profesor->getNombre() != $valor) {
                    $profesor->setNombre($valor);
                    $em->persist($profesor);
                    $em->flush();
                }
            } else {
                if ($profesor->getEmail() != $valor) {
                    $profesor->setEmail($valor);
                    $em->persist($profesor);
                    $em->flush();
                }
            }
            return new Response($valor);                
        }
    }
}

