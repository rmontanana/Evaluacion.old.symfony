<?php
/*****************************************************************************
 * AppBundle/DataFixtures/ORM/LoadNivelGrupo
 * Carga de datos de prueba en la base de datos (Nivel - Grupo)
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
use Evaluacion\AppBundle\Entity\Grupo;


class LoadNivelGrupo implements FixtureInterface, OrderedFixtureInterface
{
  
    public function load(ObjectManager $manager)
    {
        //Niveles
        $niveles = array ('Primero' => array('Primero A', 'Primero B', 'Primero C'),
                          'Segundo' => array('Segundo A', 'Segundo B'),
                          'Tercero' => array('Tercero A', 'Tercero B'),
                          'Cuarto'  => array('Cuarto A'),
                          'Primero Diversificación' => array('Primero Diversificación'),
                          'Segundo Diversificación' => array('Segundo Diversificación'));
        foreach ($niveles as $tipo => $linea) {
            $nivel = new Nivel();
            $nivel->setDescripcion($tipo);
            $manager->persist($nivel);
            foreach ($linea as $lgrupo) {
                $grupo = new Grupo();
                $grupo->setNivel($nivel);
                $grupo->setDescripcion($lgrupo);
                $manager->persist($grupo);
            }
        }
        //Graba en BD
        $manager->flush();
    }
    public function getOrder()
    {
        return 2;
    }
}