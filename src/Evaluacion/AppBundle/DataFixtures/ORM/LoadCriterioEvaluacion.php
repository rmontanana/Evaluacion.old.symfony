<?php
/*****************************************************************************
 * AppBundle/DataFixtures/ORM/LoadCriterioEvaluacion
 * Carga de datos de prueba en la base de datos (CriterioEvaluacion - Materia)
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
namespace Evaluacion\AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Evaluacion\AppBundle\Entity\Nivel;
use Evaluacion\AppBundle\Entity\Materia;
use Evaluacion\AppBundle\Entity\CriterioEvaluacion;

class LoadCriterioEvaluacion implements FixtureInterface, OrderedFixtureInterface
{
  
    public function load(ObjectManager $manager)
    {
        //Criterios de Evaluación
        $niveles = array ('Primero' => 'CriteriosEvaluacionPrimero.csv', 
                          'Segundo' => 'CriteriosEvaluacionSegundo.csv', 
                          'Tercero' => 'CriteriosEvaluacionTercero.csv', 
                          'Cuarto'  => 'CriteriosEvaluacionCuarto.csv');
        $directorio = getcwd()."/src/Evaluacion/AppBundle/DataFixtures/ORM/csv/";
        foreach ($niveles as $nivelDato => $archivo) {
            //Utilizada para saltarse la primera línea de los CSV que contiene
            //la definición de los campos
            $primero = true;
            //Obtiene el nivel que vamos a procesar.
            $nivel = $manager->getRepository("AppBundle:Nivel")->findOneBy(array('descripcion' => $nivelDato));
            $materiaAnterior = "";
            //echo "Abrimos archivo [".$directorio.$archivo."] de nivel [".$nivelDato."]\n";
            if (($gestor = fopen($directorio.$archivo, "r")) !== false) {
                //Guarda los criterios de evaluación del nivel
                while ((list($nivelDato, $materiaDato, $criterioDato) = fgetcsv($gestor, 5000, ";")) !== false) {
                    if ($primero) {
                        //Se salta la cabecera
                        $primero = false;
                        continue;
                    }
                    //Si cambiamos de materia hay que crear una materia nueva.
                    if ($materiaDato != $materiaAnterior) {
                        $materiaAnterior = $materiaDato;
                        $materia = new Materia();
                        $materia->setDescripcion($materiaDato);
                        $materia->setNivel($nivel);
                        $materia->setOptativa(false);
                        $manager->persist($materia);
                    }
                    $criterio = new CriterioEvaluacion();
                    $criterio->setDescripcion($criterioDato);
                    $criterio->setMateria($materia);
                    $manager->persist($criterio);
                }
            }
            fclose($gestor);
            //echo "Fin de proceso del archivo.\n";
        }
        $manager->flush();
    }
    public function getOrder()
    {
        return 4;
    }
}


