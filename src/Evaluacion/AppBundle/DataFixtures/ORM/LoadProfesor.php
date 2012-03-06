<?php
/****************************************************************************
 * AppBundle/DataFixtures/ORM/LoadProfesor
 * Carga de datos de prueba en la base de datos (Profesores)
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
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Evaluacion\AppBundle\Entity\Profesor;


class LoadProfesor implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
  
    public function load(ObjectManager $manager)
    {
        //Ricardo
        $profesor = new Profesor();
        $profesor->setNombre('Ricardo Montañana Gómez');
        $profesor->setEmail('rmontanana@gmail.com');
        $profesor->setUsuario('rmontanana');
        $profesor->setSalt(md5(time()));
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($profesor);
        $profesor->setPassword($encoder->encodePassword('prueba', $profesor->getSalt()));
        $profesor->setRol('ROL_ADMIN');
        $manager->persist($profesor);
        //Lucía
        $profesor = new Profesor();
        $profesor->setNombre('Lucía Montañana Fuentes');
        $profesor->setEmail('lumontanana@gmail.com');
        $profesor->setUsuario('lmontanana');
        $profesor->setSalt(md5(time()));
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($profesor);
        $profesor->setPassword($encoder->encodePassword('abcdefgh1234', $profesor->getSalt()));
        $profesor->setRol('ROL_USER');
        $manager->persist($profesor);
        //Pablo
        $profesor = new Profesor();
        $profesor->setNombre('Pablo Montañana Fuentes');
        $profesor->setEmail('pmontanana@gmail.com');
        $profesor->setUsuario('pmontanana');
        $profesor->setSalt(md5(time()));
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($profesor);
        $profesor->setPassword($encoder->encodePassword('patatafrita', $profesor->getSalt()));
        $profesor->setRol('ROL_USER');
        $manager->persist($profesor);
        //Raquel
        $profesor = new Profesor();
        $profesor->setNombre('Raquel Navarro Sánchez');
        $profesor->setEmail('raquelnavarrosa@gmail.com');
        $profesor->setUsuario('raquelnavarrosa');
        $profesor->setSalt(md5(time()));
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($profesor);
        $profesor->setPassword($encoder->encodePassword('prueba', $profesor->getSalt()));
        $profesor->setRol('ROL_USER');
        $manager->persist($profesor);
        //Graba en BD
        $manager->flush();
    }
}