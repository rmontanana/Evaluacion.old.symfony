<?php
/* ***************************************************************************
 * AppBundle/Entity/Grupo.php
 * Entidad Grupo 
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
 * Evaluacion\AppBundle\Entity\Grupo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Grupo
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
     * @var string $descripcion
     *
     * @ORM\Column(name="descripcion", type="string", length=45)
     */
    private $descripcion;

    /**
     * @var string $nivel
     *
     * @ORM\ManyToOne(targetEntity="Evaluacion\AppBundle\Entity\Nivel") 
     */
    private $nivel;

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
     * Set descripcion
     *
     * @param string $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    
    /**
     * Establece el nivel
     *
     * @param type \Evaluacion\AppBundle\Entity\Nivel
     */
    public function setNivel( $nivel)
    {
        $this->nivel = $nivel;
    }
    
    /**
     * Devuelve el nivel
     * @return type \Evaluacion\AppBundle\Entity\Nivel
     */
    public function getNivel ()
    {
        return $this->nivel;
    }
    
    public function __toString()
    {
        return $this->descripcion;
    }
}