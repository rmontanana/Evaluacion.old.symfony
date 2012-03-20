<?php
/*****************************************************************************
 * AppBundle/DataFixtures/ORM/LoadGrupoAlumno
 * Carga de datos de prueba en la base de datos (Grupo - Alumno)
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
use Evaluacion\AppBundle\Entity\Grupo;
use Evaluacion\AppBundle\Entity\Alumno;


class LoadGrupoAlumno implements FixtureInterface, OrderedFixtureInterface
{
  
    public function load(ObjectManager $manager)
    {
        //Grupos
        $grupos = array ('Primero A' => array('Juan Luis' => 'García', 'José Miguel' => 'Pérez', 'Ramón'  => 'Ramírez', 'Luisa' => 'García'),
                         'Primero B' => array('José María' => 'Paz', 'María Luisa' => 'Pez','Antonio José' => 'Poz'),
                         'Segundo A' => array('Pablo' => 'Montañana', 'Lucía' => 'Montañana'),
                         'Segundo B' => array('Ricardo' => 'Montañana', 'Raquel' => 'Navarro'),
                        );
        foreach ($grupos as $grupoLinea => $alumnos) {
            $grupo = $manager->getRepository('AppBundle:Grupo')->findOneBy(array('descripcion' => $grupoLinea));
            foreach ($alumnos as $nombre => $apellido) {
                $alumno = new Alumno();
                $alumno->setNombre($nombre);
                $alumno->setApellidos($apellido);
                $alumno->setEmail(strtolower($apellido).'@gmail.com');
                $alumno->setGrupo($grupo);
                $manager->persist($alumno);
            }
        }
        //Graba en BD
        $manager->flush();
    }
    public function getOrder()
    {
        return 5;
    }
}


