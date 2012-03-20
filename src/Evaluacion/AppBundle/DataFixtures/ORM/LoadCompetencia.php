<?php
/*****************************************************************************
 * AppBundle/DataFixtures/ORM/LoadCompetencia
 * Carga de datos de prueba en la base de datos (Competencia)
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
use Evaluacion\AppBundle\Entity\Competencia;


class LoadCompetencia implements FixtureInterface, OrderedFixtureInterface
{
  
    public function load(ObjectManager $manager)
    {
        //Competencia        
        $competencias = array ('Competencia en comunicación lingüística', 
                         'Competencia matemática', 
                         'Competencia en el conocimiento e interacción con el mundo físico',
                         'Competencia digital y de tratamiento de la información',
                         'Competencia social y ciudadana',
                         'Competencia cultural y artística',
                         'Competencia para aprender a aprender',
                         'Autonomía e iniciativa personal',
                         'Competencia emocional'
                        );
        foreach ($competencias as $competenciaLinea) {
            $competencia = new Competencia();
            $competencia->setDescripcion($competenciaLinea);
            $manager->persist($competencia);
        }
        //Graba en BD
        $manager->flush();
    }
    public function getOrder()
    {
        return 0;
    }
}


