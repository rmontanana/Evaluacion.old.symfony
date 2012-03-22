<?php
/*****************************************************************************
 * AppBundle/DataFixtures/ORM/LoadIndicadorMateria
 * Carga de datos de prueba en la base de datos (Indicador - Materia)
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
use Evaluacion\AppBundle\Entity\Indicador;
use Evaluacion\AppBundle\Entity\Unidad;

class LoadIndicadorMateria implements FixtureInterface, OrderedFixtureInterface
{
  
    public function load(ObjectManager $manager)
    {
        $niveles = array ('Primero' => array ('materia' => 'Matemáticas', 'archivo' => 'IndicadoresMatematicasPrimero.csv'), 
                         );
        $directorio = getcwd()."/src/Evaluacion/AppBundle/DataFixtures/ORM/csv/";
        foreach ($niveles as $nivelDato => $informacion) {
            //Obtiene el nivel que vamos a procesar.
            $nivel = $manager->getRepository("AppBundle:Nivel")->findOneBy(array('descripcion' => $nivelDato));
            //Obtiene la materia de ese nivel que corresponde al
            $materia = $manager->getRepository("AppBundle:Materia")->findOneBy(array ('descripcion' => $informacion['materia'], 'nivel' => $nivel->getId()));
            $unidadAnterior = "";
            //echo "Abrimos archivo [".$directorio.$archivo."] de nivel [".$nivelDato."]\n";
            if (($gestor = fopen($directorio.$informacion['archivo'], "r")) !== false) {
                //Guarda los criterios de evaluación del nivel
                while ((list($unidadDato, $indicadorDato) = fgetcsv($gestor, 5000, ";")) !== false) {
                    //Si cambiamos de unidad hay que crear una unidad nueva.
                    if ($unidadDato != $unidadAnterior) {
                        $unidadAnterior = $unidadDato;
                        $unidad = new Unidad();
                        $unidad->setDescripcion($unidadDato);
                        $unidad->setMateria($materia);
                        $manager->persist($unidad);
                    }
                    $indicador = new Indicador();
                    $indicador->setDescripcion($indicadorDato);
                    $indicador->setUnidad($unidad);
                    $manager->persist($indicador);
                }
            }
            fclose($gestor);
            //echo "Fin de proceso del archivo.\n";
        }
        $manager->flush();
    }
    public function getOrder()
    {
        return 6;
    }
}


