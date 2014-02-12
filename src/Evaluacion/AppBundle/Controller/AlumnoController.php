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
use Evaluacion\AppBundle\Entity\Alumno;


/**
 * @Route("/alum") 
 */
class AlumnoController extends Controller
{
    
    /**
     * Vamos a hacer un listado de los alumnos
     * @Route("/list", name="list_alum")
     * @return string 
     */
    public function MostrarAlumnos()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $menu = Util::getMenu();
        $usuario = "Ricardo Montanana Gomez"; $enlace="(salir)";
        $centro = "I.E.S.O. Pascual Serrano";
        $alumnos = $em->getRepository('AppBundle:Alumno')->findAll();
        $grupos = $em->getRepository('AppBundle:Grupo')->findAll();
        $param = array('titulo' => 'Alumnos', 'menu' => $menu, 'usuario' => $usuario, 'enlaceUsuario' => $enlace, 'centro' =>$centro,
                       'alumnos' => $alumnos, 'grupos' => $grupos);
        return $this->render('AppBundle:Maestros:Alumno.html.twig', $param);
    }
    
    /**
     * Vamos a hacer una alta de un alumno
     * @Route("/alta", name="alta_alum")
     * @return string 
     */
    public function AltaAlumno()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $menu = Util::getMenu();
        $usuario = "Ricardo Montanana Gomez"; $enlace="(salir)";
        $centro = "I.E.S.O. Pascual Serrano";
        $alumnos = $em->getRepository('AppBundle:Alumno')->findAll();
        $grupos = $em->getRepository('AppBundle:Grupo')->findAll();
        $form = $this->creaFormulario();
        $param = array('titulo' => 'AltaAlumnos', 'menu' => $menu,'usuario' => $usuario, 'enlaceUsuario' => $enlace, 'centro' =>$centro,
                       'alumnos' => $alumnos, 'grupos' => $grupos, 'form' => $form->createView() );
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            $datos = $form->getData();
            $alumno = new Alumno();           
            $alumno->setNombre($datos['nombre']);
            $alumno->setApellidos($datos['apellidos']);
            $alumno->setEmail($datos['email']);
            $alumno->setGrupo($datos['grupo']);
            $em->persist($alumno);
            $em->flush();
            $param = array('titulo' => 'Alumnos', 'menu' => $menu,'usuario' => $usuario, 'enlaceUsuario' => $enlace, 'centro' =>$centro,
                       'alumnos' => $alumnos, 'grupos' => $grupos);
            return $this->render('AppBundle:Maestros:Alumno.html.twig', $param);
        }
        return $this->render('AppBundle:Maestros:AltaAlumno.html.twig', $param);
    }
    
        /**
     * Crea el formulario para añadir un nuevo alumno
     * @return formulario 
     */
    private function creaFormulario()
    {    
        $factory = $this->get('form.factory');
        $builder=$this->createFormBuilder();
        $form = $builder
        ->add('nombre', 'text')
        ->add('apellidos', 'text')
        ->add('email', 'email')
        ->add('grupo', 'entity', array('class' => 'AppBundle:Grupo',
            'query_builder' => function (EntityRepository $er) {
                               $qb = $er->createQueryBuilder('c')->orderBy('c.descripcion','ASC');
                               return $qb;
                               }))
        ->getForm();
        return $form;
    }
    
    /**
     * Vamos a hacer un listado de los alumnos
     * @Route("/modAlumno", name="ajax_editarAlumno")
     * @return string 
     */
    public function ajaxEditarAlumno()
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
            $alumno = $em->getRepository('AppBundle:Alumno')
                            ->find($clave);
            if ($campo == 'nombre') {
                if ($alumno->getNombre() != $valor) {
                    $alumno->setNombre($valor);
                    $em->persist($alumno);
                    $em->flush();
                }
            } 
            elseif ($campo == 'apellidos') {
                if ($alumno->getApellidos() != $valor) {
                    $alumno->setApellidos($valor);
                    $em->persist($alumno);
                    $em->flush();
                }
            }
            elseif ($campo == 'email') {
                if ($alumno->getEmail() != $valor) {
                    $alumno->setEmail($valor);
                    $em->persist($alumno);
                    $em->flush();
                }
            }
            else {
                if ($alumno->getGrupo()->getId() != $valor) {
                    $grupo = $em->getRepository("AppBundle:Grupo")->find($valor);
                    $alumno->setGrupo($grupo);
                    $em->persist($alumno);
                    $em->flush();
                }
                return new Response($alumno->getGrupo()->getDescripcion());    
            }
            return new Response($valor);                
        }
    }
}

