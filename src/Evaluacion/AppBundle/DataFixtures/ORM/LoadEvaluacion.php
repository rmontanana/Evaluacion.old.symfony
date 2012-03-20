<?php
/*****************************************************************************
 * AppBundle/DataFixtures/ORM/LoadEvaluacion
 * Carga de datos de prueba en la base de datos (Evaluacion)
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
use Evaluacion\AppBundle\Entity\Evaluacion;


class LoadEvaluacion implements FixtureInterface, OrderedFixtureInterface
{
  
    public function load(ObjectManager $manager)
    {
        //Evaluaciones        
        $evaluaciones = array ('1ª Evaluación' => '15-12-2011', 
                               '2ª Evaluación' => '20-03-2012',
                               '3ª Evaluación' => '17-06-2012'
                              );
        foreach ($evaluaciones as $descripcion => $fecha) {
            $evaluacion = new Evaluacion();
            $evaluacion->setDescripcion($descripcion);
            $evaluacion->setFecha(new \DateTime($fecha));
            $manager->persist($evaluacion);
        }
        //Graba en BD
        $manager->flush();
    }
    public function getOrder()
    {
        return 3;
    }
}


