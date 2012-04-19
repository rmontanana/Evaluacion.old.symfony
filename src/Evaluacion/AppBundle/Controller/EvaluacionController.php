<?php
/* ***************************************************************************
 * AppBundle/Controller/EvaluacionController
 * Controlador para gestionar las evaluaciones
 * (C) Copyright 2012 Ricardo Montañana <rmontanana@gmail.com>
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
use Evaluacion\AppBundle\Entity\Competencia;
use Evaluacion\AppBundle\Entity\Unidad;
use Evaluacion\AppBundle\Entity\Materia;
use Evaluacion\AppBundle\Entity\Nivel;


/**
 * @Route("/eval") 
 */
class EvaluacionController extends Controller
{
    /**
     * Vamos a asignar las unidades didácticas a las evaluaciones
     * @Route("/asig", name="eval_asig")
     * @return string 
     */
    public function AsignacionAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $menu = Util::getMenu();
        $usuario = "Ricardo Montañana Gómez"; $enlace="(salir)";
        $centro="I.E.S.O. Pascual Serrano";
        $form = $this->creaFormulario();
        
        $param = array('titulo' => 'Asignación', 'menu' => $menu,'usuario' => $usuario, 'enlaceUsuario' => $enlace, 'centro' =>$centro,
                       'form' => $form->createView());
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            $datos = $form->getData();
            //$this->container->get('logger')->debug("datos = ".print_r($datos));
            //Arregla el dato que viene de la materia.
            $datos['Materia'] = explode('=>', $datos['Materia']);
            //$this->container->get('logger')->debug("id materia=".$datos['Materia'][0]);
            //Obtiene todos los indicadores de la materia correspondiente.
            // TODO Crear un Repositorio para Materias que permita hacer esta consulta.
            $codMateria = $datos['Materia'][0];
            $materia = $em->getRepository('AppBundle:Materia')->find($codMateria);
            $unidades = $em->getRepository('AppBundle:Materia')->findUnidadesByMateria($materia);
            //$this->container->get('logger')->debug("unidades = ".print_r($unidades));
            //$this->container->get('logger')->debug("datos = ".print_r($indicadores));
            $param = array('titulo' => 'Asignación', 'menu' => $menu,'usuario' => $usuario, 'enlaceUsuario' => $enlace, 'centro' =>$centro,
                       'datos' => $datos, 'unidades' => $unidades);
            return $this->render('AppBundle:Evaluacion:asignacionIndicador.html.twig', $param);
        }
        
        return $this->render('AppBundle:Evaluacion:asignacion.html.twig', $param);
    }
    
    /**
     * Crea el formulario para seleccionar: nivel-materia-evaluacion
     * @return formulario 
     */
    private function creaFormulario()
    {       
        $factory = $this->get('form.factory');
        $builder=$this->createFormBuilder();
        $form = $builder
            ->add('Nivel', 'entity', array('class' => 'AppBundle:Nivel', 'empty_value' => 'Selecciona Nivel',
                                           'attr'=> array("onchange" => "rellenaMateria(this.value);")))
            ->add('Materia', 'choice', array('empty_value' => 'Selecciona Materia'))
            ->add('Evaluacion', 'entity', array('class' => 'AppBundle:Evaluacion',
                                                 'query_builder' => function (EntityRepository $er) {
                                                                    $qb = $er->createQueryBuilder('c')->orderBy('c.descripcion','ASC');
                                                                    return $qb;
                                                                    }))
            ->getForm();
        return $form;
    }
    
    /**
     * @Route("/ajaxUnidad", name="ajax_unidad")
     * @return string 
     */
    public function ajaxUnidad()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $unid = $this->getRequest()->get('unidad');
            $evaluac = $this->getRequest()->get('evaluacion');
            $em = $this->getDoctrine()->getEntityManager();
            $unidad = $em->getRepository('AppBundle:Unidad')
                            ->find($unid);
            if ($evaluac == "null") {
                $unidad->setEvaluacion();
                // TODO Hay que eliminar todas las asignaciones de indicadores
            } else {
                $evaluacion = $em->getRepository('AppBundle:Evaluacion')
                                        ->find($evaluac);
                $unidad->setEvaluacion($evaluacion);
                // TODO Hay que establecer todas las asignaciones de indicadores
            }
            
            $em->persist($unidad);
            $em->flush();
            return new Response("Ok");
        }
    }
    
    /**
     * @Route("/ajaxEditarUnidad", name="ajax_editarUnidad")
     * @return string
     */
    public function ajaxEditarUnidad()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $valor = $this->getRequest()->get('value');
            $anterior = $this->getRequest()->get('anterior');
            // Si no se ha cambiado el valor de la cadena no hace nada
            if ($anterior == $valor) {
                return new Response($valor);
            }
            $clave = $this->getRequest()->get('id');
            $em = $this->getDoctrine()->getEntityManager();
            $unidad = $em->getRepository('AppBundle:Unidad')
                            ->find($clave);
            if ($unidad->getDescripcion() != $valor) {
                $unidad->setDescripcion($valor);
                $em->persist($unidad);
                $em->flush();
            }
            return new Response($valor);
                
        }
    }
}