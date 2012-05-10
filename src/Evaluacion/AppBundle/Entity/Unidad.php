<?php
/* ***************************************************************************
 * AppBundle/Entity/Unidad.php
 * Entidad Unidad didáctica
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
 * Evaluacion\AppBundle\Entity\Unidad
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Evaluacion\AppBundle\Entity\UnidadRepository")
 */
class Unidad
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
     * @ORM\Column(name="descripcion", type="string", length=255)
     */
    private $descripcion;

    /**
     * @var integer $materia
     *
     * @ORM\ManyToOne(targetEntity="Evaluacion\AppBundle\Entity\Materia")
     */
    private $materia;
    /**
     * @var integer $evaluacion
     *
     * @ORM\ManyToOne(targetEntity="Evaluacion\AppBundle\Entity\Evaluacion")
     */
    private $evaluacion;
    
    /**
     * 
     * @ORM\OneToMany(targetEntity="Evaluacion\AppBundle\Entity\Indicador", mappedBy="unidad") 
     */
    private $indicadores;

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
     * Set materia
     *
     * @param \Evaluacion\AppBundle\Entity\Materia $materia
     */
    public function setMateria($materia)
    {
        $this->materia = $materia;
    }

    /**
     * Get materia
     *
     * @return \Evaluacion\AppBundle\Entity\Materia
     */
    public function getMateria()
    {
        return $this->materia;
    }
    
    /**
     * Set materia
     *
     * @param \Evaluacion\AppBundle\Entity\Evaluacion $evaluacion
     */
    public function setEvaluacion($evaluacion)
    {
        $this->evaluacion = $evaluacion;
    }
    
    /**
     * Get evaluacion
     *
     * @return \Evaluacion\AppBundle\Entity\Evaluacion
     */
    public function getEvaluacion()
    {
        return $this->evaluacion;
    }
}