<?php
/* ***************************************************************************
 * AppBundle/Controller/CompetenciaController
 * Controlador para gestionar las competencias
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
use Evaluacion\AppBundle\Entity\Indicador;
use Evaluacion\AppBundle\Entity\Materia;
use Evaluacion\AppBundle\Entity\Nivel;


/**
 * @Route("/comp") 
 */
class CompetenciaController extends Controller
{
    /**
     * @Route("/asig", name="comp_asig")
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
            return $this->render('AppBundle:Competencia:asignacion.html.twig', $param);
        }
        
        return $this->render('AppBundle:Competencia:asignacion.html.twig', $param);
    }
    private function creaFormulario()
    {       
        $factory = $this->get('form.factory');
        $builder=$this->createFormBuilder();
        $form = $builder
            ->add('Nivel', 'entity', array('class' => 'AppBundle:Nivel', 'empty_value' => 'Selecciona Nivel',
                                           'attr'=> array("onchange" => "rellenaMateria(this.value);")))
            ->add('test', 'text')
            ->add('Materia', 'choice', array('empty_value' => 'Selecciona Materia'))
            ->add('Competencia', 'entity', array('class' => 'AppBundle:Competencia',
                                                 'query_builder' => function (EntityRepository $er) {
                                                                    $qb = $er->createQueryBuilder('c')->orderBy('c.descripcion','ASC');
                                                                    return $qb;
                                                 }
                ))
            ->getForm();
        
        /* Crea el método para actualizar por ajax las materias de un nivel. */
        $refreshMateria = function ($form, $nivel) use ($factory) {
                $form->add($factory->createNamed('entity', 'Materia2', null, array(
                                'class'         => 'AppBundle:Materia',
                                'label'         => 'Materia',
                                'query_builder' => function (EntityRepository $repository) use ($nivel) {
                                                                $qb = $repository->createQueryBuilder('materias');
                                                                            //->select('materia m'); 
                                                        if($nivel instanceof Nivel) {
                                                            $qb = $qb->where('materias.nivel = :nivel')
                                                                        ->setParameter('nivel', $nivel);
                                                        } elseif(is_numeric($nivel)) {
                                                            $qb = $qb->where('materias.nivel_id = :nivel')
                                                                        ->setParameter('nivel', $nivel);
                                                        } else {
                                                            $qb = $qb->where('materias.nivel_id = 208');
                                                        }
                                                        $qb = $qb->orderBy('materias.descripcion', 'ASC');

                                                        return $qb;
                                                    }
                        )));
        };
       
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (DataEvent $event) use ($refreshMateria) {
            $form = $event->getForm();
            $data = $event->getData();

            /*if($data == null)
                return;  //As of beta2, when a form is created setData(null) is called first
 
            if($data instanceof Nivel) {*/
                 $refreshMateria($form, $data);
            //}
        });
 
        $builder->addEventListener(FormEvents::PRE_BIND, function (DataEvent $event) use ($refreshMateria) {
            $form = $event->getForm();
            $data = $event->getData();
 
            if(array_key_exists('nivel', $data)) {
                 $refreshMateria($form, $data['nivel']);
            }
        });
        return $form;
    }
    
    /** 
     * @Route("/ajaxNivel", name="ajax_nivel")
     * @return string
     */
    public function ajaxNivel()
    {
        //return new Response(json_encode(array("hola" => $this->getRequest()->get('id'))));
        if ($this->getRequest()->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getEntityManager();
            $materias = $em->getRepository('AppBundle:Materia')->findAll()->toArray(true); //quizá creando un query?
                        //->findByNivelId($this->getRequest()->get('nivel'));
            return new Response(json_encode($materias));
        }
    }
}