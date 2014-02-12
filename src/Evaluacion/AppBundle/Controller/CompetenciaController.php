<?php

/* * **************************************************************************
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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\Event\DataEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Evaluacion\AppBundle\Util\Util;
use Evaluacion\AppBundle\Entity\Competencia;
use Evaluacion\AppBundle\Entity\Indicador;
use Evaluacion\AppBundle\Entity\Materia;
use Evaluacion\AppBundle\Entity\Nivel;

/**
 * @Route("/comp") 
 */
class CompetenciaController extends Controller {

    /**
     * @Route("/asig", name="comp_asig")
     * @return string 
     */
    public function AsignacionAction(Request $request) {
        $em = $this->getDoctrine()->getEntityManager();
        $menu = Util::getMenu();
        $usuario = "Ricardo Montañana Gómez";
        $enlace = "(salir)";
        $centro = "I.E.S.O. Pascual Serrano";
        $form = $this->creaFormulario();

        $param = array('titulo' => 'Asignación', 'menu' => $menu, 'usuario' => $usuario, 'enlaceUsuario' => $enlace, 'centro' => $centro,
            'form' => $form->createView());
        //$request = $this->getRequest();
        if ($request->isMethod('POST')) {
            
            //var_dump($materia);
            $form->handleRequest($request);
            $datos = $form->getData();
            //Mediante esta instrucción tomamos los datos del formulario que vienen en el POST porque symfony no hace bind de Materia
            $datos['Materia'] = $request->request->get("form")['Materia'];
            $datos['Materia'] = explode('=>', $datos['Materia']);
            //var_dump($request);
            //Obtiene todos los indicadores de la materia correspondiente.
            // TODO Crear un Repositorio para Materias que permita hacer esta consulta.
            $materia = $em->getRepository('AppBundle:Materia')->find($datos['Materia'][0]);
            $indicadores = $em->getRepository('AppBundle:Materia')->findIndicadoresByMateria($materia);
            //$this->container->get('logger')->debug("datos = ".print_r($indicadores));
            $param = array('titulo' => 'Asignación', 'menu' => $menu, 'usuario' => $usuario, 'enlaceUsuario' => $enlace, 'centro' => $centro,
                'datos' => $datos, 'indicadores' => $indicadores);
            return $this->render('AppBundle:Competencia:asignacionIndicadorCompetencia.html.twig', $param);
        }

        return $this->render('AppBundle:Competencia:asignacionCompetencia.html.twig', $param);
    }

    /**
     * Crea el formulario para seleccionar: nivel-materia-competencia
     * @return formulario 
     */
    private function creaFormulario() {
        //$factory = $this->get('form.factory');
        $builder = $this->createFormBuilder();
        $builder
                ->add('Nivel', 'entity', array('class' => 'AppBundle:Nivel', 'empty_value' => 'Selecciona Nivel',
                    'attr' => array("onchange" => "rellenaMateria(this.value);")))
                ->add('Materia', 'choice', array('empty_value' => 'Selecciona Materia', 'auto_initialize' => false))
                ->add('Competencia', 'entity', array('class' => 'AppBundle:Competencia',
                    'query_builder' => function (EntityRepository $er) {
                        $qb = $er->createQueryBuilder('c')->orderBy('c.descripcion', 'ASC');
                        return $qb;
                    }));
        return $builder->getForm();
    }

    /**
     * @Route("/ajaxNivel", name="ajax_nivel")
     * @return string
     */
    public function ajaxNivel() {
        //return new Response(json_encode(array("hola" => $this->getRequest()->get('id'))));
        //Si es una petición ajax continua
        if ($this->getRequest()->isXmlHttpRequest()) {
            $em = $this->getDoctrine()->getEntityManager();
            $materias = $em->getRepository('AppBundle:Materia')
                    ->findByNivel($this->getRequest()->get('id'));
            //json_encode necesita un array
            $resp = "";
            foreach ($materias as $materia) {
                $resp[] = array('id' => $materia->getId(), 'descripcion' => $materia->getDescripcion());
            }
            return new Response(json_encode($resp));
        }
    }

    /**
     * @Route("/ajaxIndicador", name="ajax_indicador")
     * @return string 
     */
    public function ajaxIndicador() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $indi = $this->getRequest()->get('indicador');
            $compe = $this->getRequest()->get('competencia');
            $em = $this->getDoctrine()->getEntityManager();
            $indicador = $em->getRepository('AppBundle:Indicador')
                    ->find($indi);
            if ($compe == "null") {
                $indicador->setCompetencia();
            } else {
                $competencia = $em->getRepository('AppBundle:Competencia')
                        ->find($compe);
                $indicador->setCompetencia($competencia);
            }

            $em->persist($indicador);
            $em->flush();
            return new Response("Ok");
        }
    }

    /**
     * @Route("/ajaxEditarIndicador", name="ajax_editarIndicador")
     * @return string
     */
    public function ajaxEditarIndicador() {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $valor = $this->getRequest()->get('value');
            $anterior = $this->getRequest()->get('anterior');
            // Si no se ha cambiado el valor de la cadena no hace nada
            if ($anterior == $valor) {
                return new Response($valor);
            }
            $clave = $this->getRequest()->get('id');
            $em = $this->getDoctrine()->getEntityManager();
            $indicador = $em->getRepository('AppBundle:Indicador')
                    ->find($clave);
            if ($indicador->getDescripcion() != $valor) {
                $indicador->setDescripcion($valor);
                $em->persist($indicador);
                $em->flush();
            }
            return new Response($valor);
        }
    }

}