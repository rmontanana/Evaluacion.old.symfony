<?php
/* ***************************************************************************
 * AppBundle/Entity/Alumno
 * Entidad Alumno
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
namespace Evaluacion\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evaluacion\AppBundle\Entity\Alumno
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Alumno
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $nombre
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string $apellidos
     *
     * @ORM\Column(name="apellidos", type="string", length=100)
     */
    private $apellidos;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=45)
     */
    private $email;

    /**
     * @var text $grupo
     *
     * @ORM\ManyToOne(targetEntity="Evaluacion\AppBundle\Entity\Grupo") 
     */
    private $grupo;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set grupo
     *
     * @param \Evaluacion\AppBundle\Entity\Grupo $grupo
     */
    public function setGrupo(\Evaluacion\AppBundle\Entity\Grupo $grupo)
    {
        $this->grupo = $grupo;
    }

    /**
     * Get grupo
     *
     * @return \Evaluacion\AppBundle\Entity\Grupo
     */
    public function getGrupo()
    {
        return $this->grupo;
    }
    
    /**
     * Devuelve la representación de un alumno
     * @return string 
     */
    public function __toString()
    {
        return $this->nombre . " " . $this->apellidos;
    }
}